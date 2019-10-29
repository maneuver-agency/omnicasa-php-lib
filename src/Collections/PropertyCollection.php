<?php

namespace Maneuver\Omnicasa\Collections;

class PropertyCollection extends BaseCollection {

  /**
   * Traverses all items inside this collection.
   * Reduces them to a distinct number of projects.
   * Creating a new collection for all others inside the first property object.
   */
  public function groupByProject($removeSubstatus = []) {
    if (!empty($this->items)) {
      $projects = [];

      // We remove properties here because otherwise an entire project can dissappaer from the site
      // if the first property in it has already been sold.
      if ($removeSubstatus) {
        $remove = [];
        foreach ($this->items as $index => $property) {
          if (in_array($property->SubStatus, $removeSubstatus)) {
            $remove[] = $property;
          }
        }
        $this->remove($remove);
      }

      foreach ($this->items as $index => $property) {
        $project_id = $property->ProjectID;

        if (!empty($project_id)) {
          if (!array_key_exists($project_id, $projects)) {
            $projects[$project_id] = [];
          }
          if (!array_key_exists($property->WebID, $projects[$project_id])) {
            // save the first item for this project.
            $property->propertiesInSameProject = new PropertyCollection();
            $projects[$project_id][$property->WebID] = $property;
          } else {
            $projects[$project_id][$property->WebID]->propertiesInSameProject->add($property);
            unset($this->items[$index]);
          }
        }
      }
    }
  }

  public function filterBySubStatus($substatus) {
    if (!empty($this->items)) {
      $list = [];

      foreach($this->items as $index => $prop) {
        if ($prop->SubStatus == $substatus) {
          $list[] = $prop;
        }
      }

      $this->items = $list;
    }

    return $this;
  }

  public function filterBy($field, $value = null) {
    if (!empty($this->items)) {
      $list = [];

      foreach($this->items as $index => $prop) {
        if (isset($prop->$field)) {
          // if (!$value || $prop->$field == $value) {
            $list[] = $prop;
          // }
        }
      }

      $this->items = $list;
    }

    return $this;
  }

}
