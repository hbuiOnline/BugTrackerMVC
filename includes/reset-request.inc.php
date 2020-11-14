<?php

include 'autoloader.inc.php';

if (isset($_POST['reset-submit'])) {

  $userEmail = $_POST['email'];

  $userObj = new UsersControl();
  $userObj->userResetPwdEmailInput($userEmail);
}

else {
  header("Location: ../reset-password.php");
}
