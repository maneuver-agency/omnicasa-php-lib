<?php

namespace Maneuver\Omnicasa\Models;

class Property extends BaseModel {

  public $propertiesInSameProject;

  public function jsonSerialize() {
    $object = $this->internalObject;
    $object->propertiesInSameProjectCount = count($this->propertiesInSameProject);
    return $object;
  }

}
