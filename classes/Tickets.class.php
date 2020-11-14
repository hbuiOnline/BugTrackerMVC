<?php

class Tickets extends Dbh {

  private function ticketDataTableShorten($ticketCreatedFormatted, $ticketId, $ticketTitle, $ticketDescription, $usersFirst, $usersLast, $ticketStatus, $ticketType, $ticketPriority, $projectName){
    $dataTableShorten =
    "<tr>
      <td>".$ticketCreatedFormatted."</td>"
      ."<td>".$ticketId."</td>"
      ."<td>".$ticketTitle."</td>"
      ."<td>".$ticketDescription."</td>"
      ."<td>".$usersFirst." ".$usersLast."</td>"
      ."<td>".$ticketStatus."</td>"
      ."<td>".$ticketType."</td>"
      ."<td>".$ticketPriority."</td>"
      ."<td>".$projectName."</td>"
      ."<td><a href="."ticketdetails.php?tid=".$ticketId.">Details</a></td>
    </tr>";
    return $dataTableShorten;
  }

  protected function ticketData($userId){ //For Ticket Datatables

    $ticketDataAll = array(array());
    $ticketData = ""; //For Admin
    $ticketOpenData = "";
    $ticketPendingData = "";
    $ticketResolvedData = "";
    $ticketClosedData = "";

    //For RBAC
    $ticketDataSubmitter = ""; //For Submitter, only see the tickets they has been submitted
    $ticketDataDevSub = ""; //For Developer, they can see both tickets submitted, and assigned
    $ticketDataProjectMananger = ""; //For Project Manager, see the tickets within the project they has been assigned


    //Ticket display for admin
    $sql = "SELECT T.ticketCreated,DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r') AS ticketCreatedFormatted, T.ticketId, T.ticketTitle, T.ticketDescription, T.ticketStatus, T.ticketType, T.ticketPriority, P.projectName, U.usersFirst, U.usersLast
    FROM tickets T, users U, project P
    WHERE T.usersIdSubmitter = U.idUsers AND T.ticketProjectId = P.projectId
    ORDER BY T.ticketId;";

    $stmt = $this->connect()->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $ticketData .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
    }

    //Ticket display for status
    $sql = "SELECT T.ticketCreated,DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r') AS
    ticketCreatedFormatted, T.ticketId, T.ticketTitle, T.ticketDescription, T.ticketStatus, T.ticketType, T.ticketPriority, P.projectName, U.usersFirst, U.usersLast
    FROM tickets T, users U, project P
    WHERE T.usersIdSubmitter = U.idUsers AND T.ticketProjectId = P.projectId AND ticketStatus = ?
    ORDER BY T.ticketId";

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(["Open"]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $ticketOpenData .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
    }

    $stmt->execute(["Pending"]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $ticketPendingData .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
    }

    $stmt->execute(["Resolved"]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $ticketResolvedData .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
    }

    $stmt->execute(["Closed"]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $ticketClosedData .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
    }

    //Ticket display for submitter
    $sql = "SELECT T.ticketCreated,DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r') AS
    ticketCreatedFormatted, T.ticketId, T.ticketTitle, T.ticketDescription, T.ticketStatus, T.ticketType, T.ticketPriority, P.projectName, U.usersFirst, U.usersLast
    FROM tickets T, users U, project P
    WHERE T.usersIdSubmitter = U.idUsers AND T.ticketProjectId = P.projectId AND usersIdSubmitter = ?
    ORDER BY T.ticketId;";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../tickets.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketDataSubmitter .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
      }
    }


    //Ticket display for Developer
    $sql = "SELECT T.ticketCreated,DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r') AS
    ticketCreatedFormatted, T.ticketId, T.ticketTitle, T.ticketDescription, T.ticketStatus, T.ticketType, T.ticketPriority, P.projectName, U.usersFirst, U.usersLast
    FROM tickets T, users U, project P
    WHERE T.usersIdSubmitter = U.idUsers AND T.ticketProjectId = P.projectId AND T.usersIdSubmitter = ?
    UNION
    SELECT T.ticketCreated,DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r') AS
    ticketCreatedFormatted, T.ticketId, T.ticketTitle, T.ticketDescription, T.ticketStatus, T.ticketType, T.ticketPriority, P.projectName, U.usersFirst, U.usersLast
    FROM tickets T, users U, project P
    WHERE T.usersIdSubmitter = U.idUsers AND T.ticketProjectId = P.projectId AND T.usersIdDev = ?;";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../tickets.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userId, $userId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketDataDevSub .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
      }
    }

    //Ticket display for project manager
    $sql = "SELECT T.ticketCreated,DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r') AS
    ticketCreatedFormatted, T.ticketId, T.ticketTitle, T.ticketDescription, T.ticketStatus, T.ticketType, T.ticketPriority, P.projectName, U.usersFirst, U.usersLast, P.projectId
    FROM tickets T, users U, project P
    WHERE T.ticketProjectId = P.projectId AND P.projectAssign = U.idUsers AND P.projectAssign = ?;";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../tickets.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketDataProjectMananger .= $this->ticketDataTableShorten($row['ticketCreatedFormatted'], $row['ticketId'], $row['ticketTitle'], $row['ticketDescription'], $row['usersFirst'], $row['usersLast'], $row['ticketStatus'], $row['ticketType'], $row['ticketPriority'], $row['projectName']);
      }
    }

    $ticketDataAll = array(
      'ticketalldata' => $ticketData,
      'ticketopendata' => $ticketOpenData,
      'ticketpendingdata' => $ticketPendingData,
      'ticketresolveddata' => $ticketResolvedData,
      'ticketcloseddata' => $ticketClosedData,
      'ticketsubmitterdata' => $ticketDataSubmitter,
      'ticketdevsubdata' => $ticketDataDevSub,
      'ticketprojectmanagerdata' => $ticketDataProjectMananger,
    );

    return $ticketDataAll;

  }//End of ticketData()

  protected function ticketCommentData($ticketId){
    $ticketCommentData = "";
    $sql = "SELECT *, DATE_FORMAT(ticketCmCreated, '%m/%d/%y %r') AS ticketCmCreatedFormatted FROM ticketsComment WHERE ticketId = ?";
    $stmt = $this->connect()->prepare($sql);

    if (!$stmt) {
      header("Location: ../ticketdetails.php?tid=".$ticketId."&error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$ticketId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketCommentData .=
        "<tr>
          <td>".$row['ticketCommenter']."</td>"
          ."<td>".$row['ticketMessage']."</td>"
          ."<td>".$row['ticketCmCreatedFormatted']."</td>
        </tr>";
      }
    }
    return $ticketCommentData;
  }//End of ticketCommentData

  protected function ticketHistoryData($ticketId){
    $ticketHistoryData = "";
    $sql = "SELECT *, DATE_FORMAT(ticketDateChanged, '%m/%d/%y %r') AS ticketChangeFormatted FROM ticketHistory WHERE ticketId = ?;";
    $stmt = $this->connect()->prepare($sql);

    if (!$stmt) {
      header("Location: ../ticketdetails.php?tid=".$ticketId."&error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$ticketId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketHistoryData .=
        "<tr>
          <td>".$row['ticketOldValue']."</td>"
          ."<td>".$row['ticketNewValue']."</td>"
          ."<td>".$row['ticketChangeFormatted']."</td>
        </tr>";
      }
    }
    return $ticketHistoryData;
  }//End of ticketHistoryData

  protected function ticketStatusCount(){
    $ticketStatusCount = array();

    $sql = "SELECT count(*) FROM tickets WHERE ticketStatus = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Open']);
    $countOpen = $stmt->fetchColumn();

    $sql = "SELECT count(*) FROM tickets WHERE ticketStatus = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Pending']);
    $countPending = $stmt->fetchColumn();

    $sql = "SELECT count(*) FROM tickets WHERE ticketStatus = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Resolved']);
    $countResolved = $stmt->fetchColumn();

    $sql = "SELECT count(*) FROM tickets WHERE ticketStatus = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Closed']);
    $countClosed = $stmt->fetchColumn();

    $ticketStatusCount = array(
      'ticketopen' => $countOpen,
      'ticketpending' => $countPending,
      'ticketresolved' => $countResolved,
      'ticketclosed' => $countClosed,
    );

    return $ticketStatusCount;
  }//End of ticketStatusCount()

  protected function ticketPriorityCount(){

    $sql = "SELECT COUNT(*) FROM tickets";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    $countAll = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) FROM tickets WHERE ticketPriority = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Urgent']);
    $countUrgent = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) FROM tickets WHERE ticketPriority = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['High']);
    $countHigh = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) FROM tickets WHERE ticketPriority = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Medium']);
    $countMedium = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) FROM tickets WHERE ticketPriority = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Low']);
    $countLow = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) FROM tickets WHERE ticketPriority = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['None']);
    $countNone = $stmt->fetchColumn();

    $ticketPriorityCount = array(
      'ticketurgent' => $countUrgent,
      'tickethigh' => $countHigh,
      'ticketmedium' => $countMedium,
      'ticketlow' => $countLow,
      'ticketnone' => $countNone,
    );

    return $ticketPriorityCount;
  }//End of ticketTypeCount()

  protected function ticketTypeShow(){

    $sql = "SELECT COUNT(*) FROM tickets";
    $stmt = $this->connect()->query($sql);
    $stmt->execute();
    $countAll = $stmt->fetchColumn();

    $sql = "SELECT COUNT(*) FROM tickets WHERE ticketType = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Bugs/Errors']);
    $countBugErrors = $stmt->fetchColumn();

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Feature Request']);
    $countFeatureRequest = $stmt->fetchColumn();

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Testing Application']);
    $countTesting = $stmt->fetchColumn();

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Training/Documents']);
    $countTraining = $stmt->fetchColumn();

    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['Other Comments']);
    $countOthers = $stmt->fetchColumn();

    $bugErrorRatio = number_format((float)($countBugErrors / $countAll * 100), 0);
    $featureRatio = number_format((float)($countFeatureRequest / $countAll * 100), 0);
    $testingRatio = number_format((float)($countTesting / $countAll * 100), 0);
    $trainingRatio = number_format((float)($countTraining / $countAll * 100), 0);
    $otherRatio = number_format((float)($countOthers / $countAll * 100), 0);

    $ticketTypeCount = array(
      'bugerror' => $countBugErrors,
      'featurereq' => $countFeatureRequest,
      'testing' => $countTesting,
      'training' => $countTraining,
      'others' => $countOthers,
      'bugratio' => $bugErrorRatio,
      'featureratio' => $featureRatio,
      'testingratio' => $testingRatio,
      'trainingratio' => $trainingRatio,
      'otherratio' => $otherRatio
    );

    return $ticketTypeCount;

  }

  protected function ticketDetail($ticketId){
    $ticketDetails = array();
    $sql = "SELECT * FROM tickets WHERE ticketId = ?;";
    $sql = "SELECT T.ticketId, T.ticketCreated,DATE_FORMAT(T.ticketUpdated,'%m/%d/%y %r') AS ticketUpdated, DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r') AS ticketCreatedFormatted,
    T.ticketTitle, T.ticketDescription, T.usersIdDev, T.ticketDeveloper, P.projectName, T.ticketPriority, T.ticketStatus, T.ticketType, U.usersFirst,  U.usersLast
    FROM tickets T, project P, users U
    WHERE T.ticketProjectId = P.projectId AND T.usersIdSubmitter = U.idUsers AND T.ticketId = ?
    ORDER BY ticketId;";
    $stmt = $this->connect()->prepare($sql);

    if (!$stmt) {
      header("Location: ../tickets.php?error=sqlerror");
    }
    else {
      $stmt->execute([$ticketId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketDetails = array(
          "title" => $row['ticketTitle'],
          "description" => $row['ticketDescription'],
          "ticketDevName" => $row['ticketDeveloper'],
          "ticketSubmitter" => $row['usersFirst']. " " . $row['usersLast'],
          "ticketProject" => $row['projectName'],
          "ticketPriority" => $row['ticketPriority'],
          "ticketStatus" => $row['ticketStatus'],
          "ticketType" => $row['ticketType'],
          "ticketCreated" => $row["ticketCreatedFormatted"],
          "ticketUpdate" => $row['ticketUpdated']
        );
      }
    }

    return $ticketDetails;
  }//End of ticketDetails

  protected function ticketDataInProject($projectId){
    $ticketData = "";

    $sql = "SELECT T.ticketId, T.ticketCreated,DATE_FORMAT(T.ticketCreated, '%m/%d/%y %r')
    AS ticketCreatedFormatted, T.ticketTitle, T.ticketDeveloper, T.ticketStatus, U.usersFirst, U.usersLast
    FROM tickets T, project P, users U
    WHERE T.ticketProjectId = P.projectId AND T.usersIdSubmitter = U.idUsers AND P.projectId = ? ORDER BY ticketId";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../projectdetails.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$projectId]);
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketData .=
        "<tr>
          <td>".$row['ticketTitle']."</td>"
          ."<td>".$row['usersFirst']." ".$row['usersLast']."</td>"
          ."<td>".$row['ticketDeveloper']."</td>"
          ."<td>".$row['ticketStatus']."</td>"
          ."<td>".$row['ticketCreatedFormatted']."</td>"
          ."<td><a href="."ticketdetails.php?tid=".$row['ticketId'].">Details</a></td>
        </tr>";

      }
    }
    return $ticketData;
  }//ticketDataInProject

  protected function ticketHistoryUpdate($newValue, $ticketId){
    //New value = $_SESSION[Name]
    //Old value = from the old "new value" insert into the old value
    //Date change will automatically update.
    $oldValue = "";

    $sql = "SELECT * FROM ticketHistory WHERE ticketId = ?;";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../ticketdetails.php?tid=".$ticketId."&error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$ticketId]);

      $resultCheck = $stmt->fetchColumn();

      if ($resultCheck == true) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $oldValue = $row['ticketNewValue'];
        }

        $sql = "UPDATE ticketHistory SET ticketOldValue = ?, ticketNewValue = ? WHERE ticketId = ?;";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../ticketdetails.php?tid=".$ticketId."&error=sqlerror");
          exit();
        }
        else {
          $stmt->execute([$oldValue, $newValue, $ticketId]);
        }
      }
      else { //If the ticket doesn't have new/old value, it will be inserted
        $sql = "INSERT INTO ticketHistory (ticketId, ticketNewValue) VALUES (?, ?);";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../ticketdetails.php?tid=".$ticketId."&error=sqlerror");
          exit();
        }
        else {
          $stmt->execute([$ticketId, $newValue]);
        }
      }

    }

  }//End of ticketHistoryUpdate

  protected function ticketCreate($ticketTitle, $ticketDescription, $ticketType, $ticketPriority,$ticketStatus,$ticketProjectId, $userId){

    $sql = "INSERT INTO tickets (ticketTitle, ticketDescription, ticketType, ticketPriority, ticketStatus, ticketProjectId, usersIdSubmitter) VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$ticketTitle, $ticketDescription, $ticketType, $ticketPriority,$ticketStatus,$ticketProjectId, $userId]);
      header("Location: ../tickets.php?ticketsubmission=success");
      exit();
    }
    $this->connect()->null;

  }//End of ticketCreate

  protected function ticketUpdate($ticketId, $ticketTitle, $ticketDescription, $ticketDevId, $ticketPriority,$ticketStatus, $ticketProjectId, $ticketType){

    $ticketDeveloper = "";

    $sql = "SELECT * FROM users WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../ticketdetails.php?tid=".$ticketId."error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$ticketDevId]);

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketDeveloper = $row['usersFirst'] . " " . $row['usersLast'];
      }

      if ($ticketDevId == 'NULL') {
        $sql = "UPDATE tickets SET ticketTitle = ?, ticketDescription = ?, usersIdDev = NULL, ticketDeveloper = NULL, ticketPriority = ?, ticketStatus = ?, ticketProjectId = ?, ticketType = ? WHERE ticketId = ?;";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../ticketdetails.php?tid=".$ticketId."error=sqlerror");
          exit();
        }
        else {
          $stmt->execute($ticketTitle, $ticketDescription, $ticketPriority, $ticketStatus, $ticketProjectId, $ticketType, $ticketId);
          header("Location: ../ticketdetails.php?tid=".$ticketId."&ticketupdate=success");
          exit();
        }
      }

      else {
        $sql = "UPDATE tickets SET ticketTitle = ?, ticketDescription = ?, usersIdDev = ?, ticketDeveloper = ?, ticketPriority = ?, ticketStatus = ?, ticketProjectId = ?, ticketType = ? WHERE ticketId = ?;";
        $stmt = $this->connect()->prepare($sql);
        if (!$stmt) {
          header("Location: ../ticketdetails.php?tid=".$ticketId."error=sqlerror");
          exit();
        }
        else {
          $stmt->execute([$ticketTitle, $ticketDescription, $ticketDevId, $ticketDeveloper, $ticketPriority, $ticketStatus, $ticketProjectId, $ticketType, $ticketId]);
          header("Location: ../ticketdetails.php?tid=".$ticketId."&ticketupdate=success");
          exit();
        }
      }
      $this->connect()->null;
    }
  }//End of ticketUpdate

  protected function ticketComment($ticketId, $ticketCommenter, $ticketMessage) {
    $sql = "INSERT INTO ticketsComment (ticketId, ticketCommenter, ticketMessage) VALUES (?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);

    if (!$stmt) {
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$ticketId, $ticketCommenter, $ticketMessage]);
      header("Location: ../ticketdetails.php?tid=".$ticketId."&ticketcomment=success");
      exit();
    }
    $this->connect()->null;
  }//End of ticketComment

}// End of class
