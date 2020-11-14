<?php

include 'autoloader.inc.php';


if (isset($_POST['report-request'])) {

  $mpdfObj = new ReportControl();
  $mpdfObj->pdfReportRequest();

}
else {
  header("Location: ../dashboard.php");
}
