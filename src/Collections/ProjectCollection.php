<?php

namespace Maneuver\Omnicasa\Collections;

class ProjectCollection extends BaseCollection {

  public function filterBySubStatus($substatus) {
    if (!empty($this->items)) {
      $list = [];

      foreach($this->items as $index => $project) {
        if ($project->SubstatusID == $substatus) {
          $list[] = $project;
        }
      }

      $this->items = $list;
    }

    return $this;
  }

  public function sort() {
    if (is_array($this->items)) {
      usort($this->items, array($this, 'sortByShowOrder'));
    }
  }

  private function sortByShowOrder($item1, $item2) {
    $a = $item1->ShowOrder;
    $b = $item2->ShowOrder;
    return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
  }

}
