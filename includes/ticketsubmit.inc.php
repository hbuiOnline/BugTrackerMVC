<?php

session_start();
include 'autoloader.inc.php';
$ticketObj = new TicketsControl();

if (isset($_POST['ticket-submit'])) {

  $ticketTitle = $_POST['tickettitle'];
  $ticketDescription = $_POST['ticketdescription'];
  $ticketType = $_POST['tickettype'];
  $ticketPriority = $_POST['ticketpriority'];
  $ticketStatus = $_POST['ticketstatus'];
  $ticketProjectId = $_POST['projectname'];


  if (empty($ticketTitle) || empty($ticketDescription) || empty($ticketType) || empty($ticketPriority) || empty($ticketStatus) || empty($ticketProjectId)) {
    header("Location: ../tickets.php?error=emptyfields&tickettitle=".$ticketTitle."&titicketdescription=".$ticketDescription);
    exit();
  }
  else {
    $ticketObj->ticketCreateInput($ticketTitle, $ticketDescription, $ticketType, $ticketPriority, $ticketStatus, $ticketProjectId, $_SESSION['userID']);
  }
}

elseif (isset($_POST['ticket-comment'])) {
  $ticketId = $_POST['tid'];
  $ticketCommenter = $_SESSION['userFirst'] . " " .$_SESSION['userLast'];
  $ticketMessage = $_POST['ticketmessage'];

  if (empty($ticketMessage)) {
    header("Location: ../ticketdetails.php?tid=".$ticketId."&error=emptyfield");
    exit();
  }
  else {
    $ticketObj->ticketCommentInput($ticketId, $ticketCommenter, $ticketMessage);
  }

}

elseif (isset($_POST['ticket-update'])) {
  $ticketId = $_POST['tid'];
  $ticketTitle = $_POST['tickettitle'];
  $ticketDescription = $_POST['ticketdescription'];
  $ticketDevId = $_POST['assignto'];
  $ticketPriority = $_POST['ticketpriority'];
  $ticketStatus = $_POST['ticketstatus'];
  $ticketProjectId = $_POST['projectid'];
  $ticketType = $_POST['tickettype'];

  $ticketNewValue = $_SESSION['userFirst'] . " " . $_SESSION['userLast']; //For ticketHistory

  $ticketObj->ticketHistoryUpdateInput($ticketNewValue, $ticketId);
  $ticketObj->ticketUpdateInput($ticketId, $ticketTitle, $ticketDescription, $ticketDevId, $ticketPriority,$ticketStatus, $ticketProjectId, $ticketType);

}

else {
  header("Location: ../dashboard.php");
}
