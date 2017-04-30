<?php

namespace Maneuver\Omnicasa;

class Demand extends ClientWrapper {

  public function contactOnMe($args = []) {
    $result = $this->makeRequest('ContactOnMe', $args);
    return $result;
  }

  public function contactOnMeProject($args = []) {
    $result = $this->makeRequest('ContactOnMeProject', $args);
    return $result;
  }

  public function change($args = []) {
    $result = $this->makeRequest('DemandRegister', $args);
    return $result;
  }

  public function register($args = []) {
    $result = $this->makeRequest('DemandRegister', $args);
    return $result;
  }

  public function unregister($args = []) {
    $result = $this->makeRequest('UnsubscribeDemandPerson', $args);
    return $result;
  }

  public function find($person_id, $demand_id) {
    $args = [
      'ID' => $person_id,
      'DemandID' => $demand_id,
    ];
    $result = $this->makeRequest('GetDemandPerson', $args);
    return $result;
  }

}
