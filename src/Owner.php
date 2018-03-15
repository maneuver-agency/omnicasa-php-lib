<?php

namespace Maneuver\Omnicasa;

class Owner extends ClientWrapper {

  public function login($email, $pass) {
    $args['Email'] = $email;
    $args['Password'] = $pass;
    $result = $this->makeRequest('CheckPersonLogin', $args);
    return $result;
  }

  public function getPerson($email, $pass) {
    $args['Email'] = $email;
    $args['Password'] = $pass;
    $result = $this->makeRequest('GetPerson', $args);
    return $result;
  }

  public function getPersonByID($id) {
    $args['ID'] = $id;
    $result = $this->makeRequest('GetPerson', $args);
    return $result;
  }

  public function getActivity($property_id, $from_date = null, $to_date = null) {
    $args['ObjectID'] = $property_id;
    $result = $this->makeRequest('GetAutomaticHistories', $args);
    return $result;
  }

  public function getStats($property_id) {
    $args['ID'] = $property_id;
    $result = $this->makeRequest('GetVisitStatisticOfProperty', $args);
    return $result;
  }

  public function getCalendar($property_id, $from_date = null, $to_date = null, $args = []) {
    $args['ObjectID'] = $property_id;
    if ($from_date) {
      $args['FromDate'] = $from_date;
    }
    if ($to_date) {
      $args['ToDate'] = $to_date;
    }
    $result = $this->makeRequest('GetCalendarHistories', $args);
    return $result;
  }

  public function getStatisticsGraphList($property_id, $from_date = null, $to_date = null, $args = []) {
    $args['ObjectIDs'] = $property_id;
    if ($from_date) {
      $args['StartDate'] = $from_date;
    }
    if ($to_date) {
      $args['EndDate'] = $to_date;
    }
    $result = $this->makeRequest('GetMediaObjectStatisticsGraphList', $args);
    return $result;
  }
}
