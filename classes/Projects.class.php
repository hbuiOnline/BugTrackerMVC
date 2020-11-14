<?php

use PhpRbac\Rbac;

class Projects extends Dbh {

  protected function projectsData($userId){   //this is for the datatable

    $projectDataAll = array(array());
    $projectData = ""; // For  Admin
    $projectDataForManager = ""; //For project-manager

    $sql = "SELECT *,DATE_FORMAT(projectCreate, '%m/%d/%y %r') AS projectCreatedFormatted FROM project;";
    $stmt = $this->connect()->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $projectData .=
      "<tr>
        <td>".$row['projectCreatedFormatted']."</td>"
        ."<td>".$row['projectId']."</td>"
        ."<td>".$row['projectName']."</td>"
        ."<td>".$row['projectDescription']."</td>"
        ."<td>".$row['projectAssignName']."</td>"
        ."<td><a href="."projectdetails.php?pid=".$row['projectId'].">Details</a></td>
      </tr>";
    }

    $sql = "SELECT *,DATE_FORMAT(projectCreate, '%m/%d/%y %r') AS projectCreatedFormatted
    FROM project
    WHERE projectAssign = ?";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../projectdetails.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $projectDataForManager .=
        "<tr>
          <td>".$row['projectCreatedFormatted']."</td>"
          ."<td>".$row['projectId']."</td>"
          ."<td>".$row['projectName']."</td>"
          ."<td>".$row['projectDescription']."</td>"
          ."<td>".$row['projectAssignName']."</td>"
          ."<td><a href="."projectdetails.php?pid=".$row['projectId'].">Details</a></td>
        </tr>";
      }
    }

    $projectDataAll = array(
      'projectalldata' => $projectData,
      'projectmanagerdata' => $projectDataForManager,
    );

    return $projectDataAll;
  }//End of projectsData

  protected function projectAssignedPersonnel($projectId){
    $projectPersonnel = "";
    $sql = "SELECT P.projectAssign, U.usersEmail, U.usersRole, U.usersFirst, U.usersLast
    FROM project P, users U
    WHERE P.projectAssign = U.idUsers AND P.projectId = ?
    ORDER BY projectId";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../projectdetails.php?pid=".$projectId."&error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$projectId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $projectPersonnel .=
        "<tr>
          <td>".$row['usersFirst']." ".$row['usersLast']."</td>"
          ."<td>".$row['usersEmail']."</td>"
          ."<td>".$row['usersRole']."</td>
        </tr>";
      }
    }

    return $projectPersonnel;

  }//End of projectAssignedPersonnel

  protected function projectDetail($projectId){
    $projectDetails = array();
    $sql = "SELECT * FROM project WHERE projectId = ?";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../projects.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$projectId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $projectDetails = array(
          "name" => $row['projectName'],
          "description" => $row['projectDescription'],
        );
      }
    }
    return $projectDetails;
  } // End of projectDetail

  protected function projectDataOptions(){
    $sql = "SELECT * FROM project;";
    $stmt = $this->connect()->query($sql);
    $projectOptions = "";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $projectOptions .= "<option value=".$row['projectId'].">".$row['projectName']."</option>";
    }

    return $projectOptions;
  }//End of projectDataOptions

  protected function projectCreate($projectTitle, $projectDescription, $projectAssgin){

    $sql = "INSERT INTO project (projectName, projectDescription, projectAssign) VALUES (?, ?, ?);";
    $stmt = $this->connect()->prepare($sql);

    if (!$stmt) {
      header("Location: ../projects.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$projectTitle, $projectDescription, $projectAssgin]);
      header("Location: ../projects.php?projectcreated=success");
      exit();
    }
    $this->connect()->null;

  }//End of projectCreate

  protected function projectAssign($userAssign, $projectId){

    require '../vendor/autoload.php';
    $rbac = new Rbac();

    $projectAssignName = "";
    $sql = "SELECT * FROM users WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../projects.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userAssign]);

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $projectAssignName = $row['usersFirst']." ".$row['usersLast'];
      }

      if ($userAssign == NULL) { //This is for enter the NULL value into the database
        $sql = "UPDATE project SET projectAssign = NULL, projectAssignName = ? WHERE projectId = ?;";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../projects.php?error=sqlerror");
          exit();
        }
        else {
          $stmt->execute([$projectAssignName, $projectId]);
          header("Location: ../projects.php?projectassign=success");
          exit();
        }
      }

      elseif ($rbac->Users->hasRole('project-manager', $userAssign)) {

        $sql = "UPDATE project SET projectAssign = ?, projectAssignName = ? WHERE projectId = ?;";
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt) {
          header("Location: ../projects.php?error=sqlerror");
          exit();
        }
        else {
          $stmt->execute([$userAssign,$projectAssignName, $projectId]);
          header("Location: ../projects.php?projectassign=success");
          exit();
        }
      }

      else {
        header("Location: ../projects.php?error=notprojectmanager");
        exit();
      }

      $this->connect()->null;
    }
  }//End of projectAssign

  protected function projectUpdate($projectId, $projectAssign, $projectTitle, $projectDescription){
    $projectAssignName = "";

    $sql = "SELECT * FROM users WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../projectdetails.php?pid=".$projectId."&error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$projectAssign]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $projectAssignName = $row['usersFirst'] . " " . $row['usersLast'];
      }

      if ($projectAssign == 'NULL') {
        $sql = "UPDATE project SET projectName = ?, projectDescription = ?, projectAssign = NULL, projectAssignName = NULL WHERE projectId = ?;";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../projectdetails.php?pid=".$projectId."&error=sqlerror");
          exit();
        }
        else {
          $stmt->execute([$projectTitle, $projectDescription, $projectId]);
          header("Location: ../projectdetails.php?pid=".$projectId."&projectupdate=success");
          exit();
        }
      }

      else {
        $sql = "UPDATE project SET projectName = ?, projectDescription = ?, projectAssign = ?, projectAssignName = ? WHERE projectId = ?;";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../projectdetails.php?pid=".$projectId."&error=sqlerror");
          exit();
        }
        else {
          $stmt->execute([$projectTitle, $projectDescription, $projectAssign, $projectAssignName, $projectId]);
          header("Location: ../projectdetails.php?pid=".$projectId."&projectupdate=success");
          exit();
        }
      }
      $this->connect()->null;
    }
  }
}//End of projectUpdate
