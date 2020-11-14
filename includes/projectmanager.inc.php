<?php

session_start();
require 'autoloader.inc.php';

if (isset($_POST['project-create'])) {

  $projectTitle = $_POST['projecttitle'];
  $projectDescription = $_POST['projectdescription'];
  $projectAssign = $_POST['assignto'];

  $projectObj = new ProjectsControl();

  if (empty($projectTitle) || empty($projectDescription)) {
    header("Location: ../projects.php?error=emptyfields&projectitle=".$projectTitle."&=projectdescription".$projectDescription);
    exit();
  }

  else {
    $projectObj->projectCreateInput($projectTitle, $projectDescription, $projectAssign);
  }

}
elseif (isset($_POST['project-assign'])) {

  $projectUserAssign = $_POST['userassign'];
  $projectId = $_POST['projectid'];

  $projectObj = new ProjectsControl();
  $projectObj->projectAssignInput($projectUserAssign, $projectId);
}

elseif (isset($_POST['project-update'])) {
  $projectId = $_POST['pid'];
  $projectTitle = $_POST['projecttitle'];
  $projectDescription = $_POST['projectdescription'];
  $projectAssign = $_POST['assignto'];

  $projectObj = new ProjectsControl();
  $projectObj->projectUpdateInput($projectId, $projectAssign, $projectTitle, $projectDescription);


}

else {
  header("Location: ../dashboard.php");
}
