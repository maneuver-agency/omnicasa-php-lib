<?php

namespace Maneuver\Omnicasa\Collections;

use \Maneuver\Omnicasa\Models\BaseModel;

class BaseCollection implements \IteratorAggregate, \JsonSerializable, \Countable {

  private $position = 0;
  protected $items = [];

  public function __construct($list = []) {
    $this->position = 0;
    $this->items = $list;
  }

  public function add(BaseModel $model) {
    array_push($this->items, $model);
  }

  public function get($index) {
    if (!empty($this->items[$index])) {
      return $this->items[$index];
    }
  }

  /* Implementation of IteratorAggregate */

  public function getIterator() {
    if (is_array($this->items)) {
      return new \ArrayIterator($this->items);
    } else {
      return new \ArrayIterator(array());
    }
  }

  public function jsonSerialize() {
    return array_values($this->items);
  }

  public function count() {
    return count($this->items);
  }

  public function remove($arr = []) {
    foreach ($arr as $i) {
      array_splice($this->items, $i, 1);
    }
  }

  public function slice($start = 0, $length = null) {
    $slice = [];
    if (is_array($this->items)) {
      $slice = array_slice($this->items, $start, $length);
    }
    return new self($slice);
  }

  public function shuffle() {
    if (is_array($this->items)) {
      return shuffle($this->items);
    }
    return false;
  }

  public function sortBy($key) {
    if (is_array($this->items)) {
      usort($this->items, function($a, $b) use ($key) {
        return strcmp($a->$key, $b->$key);
      });
    }
  }

  public function reverse() {
    if (is_array($this->items)) {
      $this->items = array_reverse($this->items);
    }
  }


}
