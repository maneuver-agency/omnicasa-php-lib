<?php

namespace Maneuver\Omnicasa;

use \Maneuver\Omnicasa\Collections\PropertyCollection;

class Property extends ClientWrapper {

  protected $modelClass = 'Property';

  public function getPropertyList($fields = [], $sortBy = [], $args = []) {
    if (is_null($fields)) {
      $fields = $this->fields;
    }

    if (is_array($fields)) {
      array_unshift($fields, 'ID');
      $args['DisplayFields'] = implode($fields, ',');
    }

    if (empty($sortBy)) {
      $sortBy = 'CreatedDate';
    }
    if (is_string($sortBy)) {
      $sortBy = [$sortBy];
    };
    $args['SortFields'] = implode($sortBy, ',');

    $result = $this->makeRequest('GetPropertyList', $args);

    //** Use alternative method:
    // $result = $this->makeRequest('GetPropertyList2', $args);
    // $result = array_map(function($o){ return $o->Object; }, $result);
    //**

    return new PropertyCollection($result);
  }

  public function getProperty($id, $add_view = FALSE) {
    $args['ID'] = $id;
    $args['UpdateVisit'] = $add_view;
    $result = $this->makeRequest('GetProperty', $args);
    return $result;
  }

  public function getPropertiesByMarquee($marqueeName, $args = []) {
    $marquees = $this->client->settings->getMarqueeList();
    if (is_array($marquees)) {
      $marquees = array_filter($marquees, function($item) use ($marqueeName) { if ($item->Name == $marqueeName) return $item; });
      if (!empty($marquees)) {
        $marquee = reset($marquees);
        return $this->getPropertyList($args, [], ['MarqueeIDs' => $marquee->ID]);
      }
    }
    return new PropertyCollection([]);
  }

  public function getCountProperties($args = []) {
    $countConditions = [
      $args
    ];
    $args['CountConditions'] = $countConditions;
    $result = $this->makeRequest('GetCountProperties', $args, true);

    if ($result) {
      return $result[0];
    }
  }
}