<?php

namespace Maneuver\Omnicasa;

class Settings extends ClientWrapper {

  const GOAL_RENT = 1;
  const GOAL_SALES = 0;

  /**
   * Get a list of all WebID's.
   * @param  array $args   Extra query arguments.
   * @return array         List of objects.
   */
  public function getTypesList($args = []) {
    return $this->makeCacheRequest('GetWebIDList', $args);
  }

  public function getType($id) {
    $args['ID'] = $id;
    $result = $this->client->makeRequest('GetWebID', $args);
    return $result;
  }

  /************************/
  /*** SHORTCUT METHODS ***/
  /************************/

  /**
   * Get the price ranges only for Sales.
   *
   * @param  array $args   Extra query arguments.
   * @return array         List of price range objects.
   */
  public function getPriceRangeSales($args = []) {
    $args['Goal'] = static::GOAL_SALES;
    return $this->getPriceRangeList($args);
  }

  /**
   * Get the price ranges only for Rent.
   *
   * @param  array $args   Extra query arguments.
   * @return array         List of price range objects.
   */
  public function getPriceRangeRent($args = []) {
    $args['Goal'] = static::GOAL_RENT;
    return $this->getPriceRangeList($args);
  }

}
