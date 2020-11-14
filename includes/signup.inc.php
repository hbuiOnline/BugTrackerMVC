<?php

include 'autoloader.inc.php';

if (isset($_POST['signup-submit'])) {

  $userFirst = $_POST['uidfirst'];
  $userLast = $_POST['uidlast'];
  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $confirmPwd = $_POST['pwd-confirm'];

  $usersObj = new UsersControl();
  $usersObj->validateUserInput($userFirst, $userLast, $username, $email, $password, $confirmPwd);

}

else {
  header("Location: ../signup.php");
}
