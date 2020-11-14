<?php

class ProjectsView extends Projects {

  public function projectDataOptionsInput(){
    $result = $this->projectDataOptions();
    echo $result;
  }

  public function projectDataShow($userId){
    $result = array(array());
    $result = $this->projectsData($userId);
    return $result;
  }

  public function projectDetailShow($projectId){
    $result = array();
    $result = $this->projectDetail($projectId);
    return $result;
  }

  public function projectAssignedPersonnelShow($projectId){
    $result = $this->projectAssignedPersonnel($projectId);
    echo $result;
  }

}
