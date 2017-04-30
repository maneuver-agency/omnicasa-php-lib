<?php

namespace Maneuver\Omnicasa\Models;

class BaseModel implements \JsonSerializable {

  protected $internalObject;

  public function __construct($object) {
    $this->internalObject = $object;
  }

  public function __get($name) {
    if (property_exists($this->internalObject, $name)) {
      return $this->internalObject->$name;
    }
  }

  public function set($name, $value) {
    return $this->internalObject->$name = $value;
  }

  public function __isset($name) {
    return isset($this->internalObject->$name);
  }

  public function jsonSerialize() {
    return $this->internalObject;
  }

}
