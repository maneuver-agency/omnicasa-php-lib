<?php

// http://wiki.omnicasa.com/display/ManuelFR/Omnicasa+APIV2+%3A+Documentation

namespace Maneuver\Omnicasa;

class Client {

  private $_username, $_password;
  private $_language;

  private $_langs = ['nl' => 1, 'fr' => 2, 'en' => 3];
  public $defaultLanguage = 1;

  public $settings, $general;

  public function __construct($username, $password, $language = 'nl') {
    $this->_username = $username;
    $this->_password = $password;

    $this->_language = isset($_langs[$language]) ? $_langs[$language] : $this->defaultLanguage;

    $this->settings = new Settings($this);
    $this->general = new General($this);
  }

  public function makeRequest($endpoint, $data = []) {

    $params = array_merge([
      'CustomerName' => $this->_username,
      'CustomerPassword' => $this->_password,
      'LanguageId' => $this->_language,
    ], $data);

    // var_dump($params);exit;

    $params = urlencode(json_encode($params));
    $endpoint .= 'Json';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://newapi.omnicasa.com/1.8/OmnicasaService.svc/'. $endpoint .'?json=' . $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($output);
    $data = null;

    $key = $endpoint . 'Result';
    if (!empty($result->$key)) {
      $result = $result->$key;

      if ($result->Code > 0 && !$result->Success) {
        // $this->showError($result->Message);
      }

      $data = $result->Value;

      if (isset($data->Items)) {
        $data = $data->Items;
      }
    } else if (isset($result->Value) && is_object($result->Value)) {
      $data = $result->Value;
    }

    return $data;
  }

  protected function showError($message) {
    throw new \Exception($message);
  }
}
