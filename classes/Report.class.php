<?php

require_once '../vendor/autoload.php';

class Report extends Dbh {

  protected function pdfReport(){

    $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

    $projectArray = $this->projectReport();
    $ticketArray = $this->ticketReport();

    $pdfData .= "<style>
                h1 {
                  text-align:center;
                  color : #4e73df;
                }
                table, th, td {
                  border: 1px solid black;
                  border-collapse: collapse;
                  text-align:center;
                }
                </style>";

    $pdfData .= "<h1>Bug Tracker MVC Report</h1>";
    $pdfData .= '<hr>';

    $pdfData .= "<h2>Project Report</h2>";
    $pdfData .= "<strong>Number of Projects: </strong>".$projectArray['projectcount'];
    $pdfData .= "<br><br>";
    $pdfData .= //This is for table display of tickets of project
    "<table style="."border-style".">
      <thead>
          <tr>
            <th>Project Name</th>
            <th>Project Description</th>
            <th>Number of Tickets</th>
          </tr>
      </thead>
      <tbody>
        ".$projectArray['projectsummary']."
      </tbody>
    </table>";

    $pdfData .= '<hr>';
    $pdfData .= "<h2>Ticket Report</h2>";
    $pdfData .= "<strong>Number of Tickets: </strong>".$ticketArray['ticketcount'];
    $pdfData .= "<br><br>";
    $pdfData .= //This is for table display of tickets of project
    "<table>
      <thead>
          <tr>
            <th>Ticket Title</th>
            <th>Ticket Description</th>
          </tr>
      </thead>
      <tbody>
        ".$ticketArray['ticketsummary']."
      </tbody>
    </table>";

    $pdfData .= "<h3>Ticket Types</h3>";
    $pdfData .= //This is for table display of tickets of project
    "<table>
      <thead>
          <tr>
            <th>Ticket Type</th>
            <th>Number of Tickets</th>
          </tr>
      </thead>
      <tbody>
        ".$ticketArray['tickettype']."
      </tbody>
    </table>";

    $pdfData .= "<h3>Ticket Status</h3>";
    $pdfData .= //This is for table display of tickets of project
    "<table>
      <thead>
          <tr>
            <th>Ticket Status</th>
            <th>Number of Tickets</th>
          </tr>
      </thead>
      <tbody>
        ".$ticketArray['ticketstatus']."
      </tbody>
    </table>";

    $pdfData .= "<h3>Ticket Priority</h3>";
    $pdfData .= //This is for table display of tickets of project
    "<table>
      <thead>
          <tr>
            <th>Ticket Priority</th>
            <th>Number of Tickets</th>
          </tr>
      </thead>
      <tbody>
        ".$ticketArray['ticketpriority']."
      </tbody>
    </table>";



    $mpdf->WriteHTML($pdfData);

    $mpdf->Output(); //1st param: naming the pdf file
                    //2nd param:D for download

    header("Location: ../dashboard.php");


  }

  private function projectReport(){

    $projectCount = "";
    $projectSummary = "";

    $sql = "SELECT COUNT(*) FROM project;";
    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../dashboard.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      $projectCount = $stmt->fetchColumn();
    }

    $sql = "SELECT P.projectName, P.projectDescription, COUNT(*) AS NumberOfTickets
            FROM tickets T, project P
            WHERE T.ticketProjectId = P.projectId
            GROUP BY P.projectId;";
    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../dashboard.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $projectSummary .=
        "<tr>
          <td>".$row['projectName']."</td>"
          ."<td>".$row['projectDescription']."</td>"
          ."<td>".$row['NumberOfTickets']."</td>
        </tr>";
      }
    }

    $projectArray = array(
      'projectcount' => $projectCount,
      'projectsummary' => $projectSummary,
    );

    return $projectArray;

  }//End projectReport

  private function ticketReport(){

    $ticketCount = "";
    $ticketSummary = "";
    $ticketType = "";
    $ticketStatus = "";
    $ticketPriority = "";


    //Ticket Count
    $sql = "SELECT COUNT(*) FROM tickets;";
    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../dashboard.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      $ticketCount = $stmt->fetchColumn();
    }

    //Ticket Summary
    $sql = "SELECT T.ticketTitle, T.ticketDescription FROM tickets T;";
    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../dashboard.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketSummary .=
        "<tr>
          <td>".$row['ticketTitle']."</td>"
          ."<td>".$row['ticketDescription']."</td>
        </tr>";
      }
    }

    //Ticket Type COUNT
    $sql = "SELECT T.ticketType ,COUNT(*) AS NumberOfTickets
            FROM tickets T
            GROUP BY T.ticketType";
    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../dashboard.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketType .=
        "<tr>
          <td>".$row['ticketType']."</td>"
          ."<td>".$row['NumberOfTickets']."</td>
        </tr>";
      }
    }

    //Ticket Status COUNT
    $sql = "SELECT T.ticketStatus ,COUNT(*) AS NumberOfTickets
            FROM tickets T
            GROUP BY T.ticketStatus";
    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../dashboard.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketStatus .=
        "<tr>
          <td>".$row['ticketStatus']."</td>"
          ."<td>".$row['NumberOfTickets']."</td>
        </tr>";
      }
    }

    //Ticket Priority COUNT
    $sql = "SELECT T.ticketPriority ,COUNT(*) AS NumberOfTickets
            FROM tickets T
            GROUP BY T.ticketPriority";
    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../dashboard.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketPriority .=
        "<tr>
          <td>".$row['ticketPriority']."</td>"
          ."<td>".$row['NumberOfTickets']."</td>
        </tr>";
      }
    }


    $ticketArray = array(
      'ticketcount' => $ticketCount,
      'ticketsummary' => $ticketSummary,
      'tickettype' => $ticketType,
      'ticketstatus' => $ticketStatus,
      'ticketpriority' => $ticketPriority,
    );

    return $ticketArray;

  }//End of ticketReport

}
