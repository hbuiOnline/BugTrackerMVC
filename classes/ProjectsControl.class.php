<?php

class ProjectsControl extends Projects {

  public function projectCreateInput($projectTitle, $projectDescription, $projectAssgin){
    $this->projectCreate($projectTitle, $projectDescription, $projectAssgin);
  }

  public function projectAssignInput($userAssign, $projectId){
    $this->projectAssign($userAssign, $projectId);
  }

  public function projectUpdateInput($projectId, $projectAssign, $projectTitle, $projectDescription){
    $this->projectUpdate($projectId, $projectAssign, $projectTitle, $projectDescription);
  }
}
