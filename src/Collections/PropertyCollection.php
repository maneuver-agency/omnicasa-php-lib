<?php

namespace Maneuver\Omnicasa\Collections;

class PropertyCollection extends BaseCollection {

  /**
   * Traverses all items inside this collection.
   * Reduces them to a distinct number of projects.
   * Creating a new collection for all others inside the first property object.
   */
  public function groupByProject() {
    if (!empty($this->items)) {
      $projects = [];

      foreach ($this->items as $index => $property) {
        $project_id = $property->ProjectID;

        if (!empty($project_id)) {
          if (!array_key_exists($project_id, $projects)) {
            // save the first item for this project.
            $property->propertiesInSameProject = new PropertyCollection();
            $projects[$project_id] = $property;
          } else {
            $projects[$project_id]->propertiesInSameProject->add($property);
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

}
