<?php

namespace Maneuver\Omnicasa;

use \Maneuver\Omnicasa\Collections\ProjectCollection;

class Construction extends ClientWrapper {

  protected $modelClass = 'Project';

  /**
   * Retrieve a list of all projects.
   */
  public function getProjectList($args = []) {
    $result = $this->makeRequest('GetProjectList', $args);
    return new ProjectCollection($result);
  }

  /**
   * Retrieve a list of all buildings.
   */
  public function getBuildingList($args = []) {
    // TODO: shouldn't return Project objects!
    $result = $this->makeRequest('GetBuildingList', $args);
    return $result;
  }

  /**
   * Retrieve a specific project by ID.
   */
  public function getProject($id, $args = []) {
    $args['ID'] = $id;
    // $args['IsPublishInternet'] = false;
    $result = $this->makeRequest('GetProject', $args);
    return $result;
  }

}
