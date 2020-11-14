<?php

include 'autoloader.inc.php';

if (isset($_POST['login-submit'])) {

  $mailUser = $_POST['mailusername'];
  $password = $_POST['password'];

  $userObj = new UsersControl();
  $userObj->userLoginInput($mailUser, $password);
}

elseif (isset($_POST['admin-login-submit'])) {
  $demoUsername = $_POST['demousername'];
  $userObj = new UsersControl();
  $userObj->demoUserLoginInput($demoUsername);
}

elseif (isset($_POST['projectmanager-login-submit'])) {
  $demoUsername = $_POST['demousername'];
  $userObj = new UsersControl();
  $userObj->demoUserLoginInput($demoUsername);
}

elseif (isset($_POST['dev-login-submit'])) {
  $demoUsername = $_POST['demousername'];
  $userObj = new UsersControl();
  $userObj->demoUserLoginInput($demoUsername);
}

elseif (isset($_POST['submitter-login-submit'])) {
  $demoUsername = $_POST['demousername'];
  $userObj = new UsersControl();
  $userObj->demoUserLoginInput($demoUsername);
}

else {
  header("Location: ../index.php");
  exit();
}
