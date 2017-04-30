<?php

namespace Maneuver\Omnicasa;

class ClientWrapper {

  protected $client;
  protected $fields = [];

  private $cache = [];

  public function __construct($client) {
    $this->client = $client;
  }

  public function __call($method, $args = []) {
    return $this->makeRequest(ucfirst($method), !empty($args) ? reset($args) : []);
  }

  public function setDisplayFields($fields = []) {
    $this->fields = $fields;
  }

  protected function makeRequest($method, $args = []) {
    $result = $this->client->makeRequest($method, $args);
    return $this->classFactory($result);
  }

  protected function makeCacheRequest($method, $args = [], $reset = false) {
    $cacheKey = base64_encode($method . serialize($args));

    if (!$reset && $result = $this->getCache($cacheKey)) {
      return $this->classFactory($result);
    }

    $result = $this->makeRequest($method, $args);
    // NOTE: cache the bare objects, not the models.
    $this->setCache($cacheKey, $result);

    return $this->classFactory($result);
  }

  protected function getCache($key) {
    if (!empty($this->cache[$key])) {
      return $this->cache[$key];
    }
  }

  protected function setCache($key, $data) {
    $this->cache[$key] = $data;
  }

  protected function classFactory($input) {
    if (isset($this->modelClass)) {
      $class = '\\Maneuver\\Omnicasa\Models\\' . $this->modelClass;
      if (class_exists($class)) {
        if (is_object($input)) {
          $input = new $class($input);
        } else if (is_array($input)) {
          $input = array_map(function($o) use ($class) { return new $class($o); }, $input);
        }
      }
    }
    return $input;
  }
}
