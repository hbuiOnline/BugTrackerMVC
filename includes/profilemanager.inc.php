<?php
include 'autoloader.inc.php';

if (isset($_POST['profile-update'])) {

  $userObj = new UsersControl();

  $userId = $_POST['uid'];
  $userFirst = $_POST['userfirst'];
  $userLast = $_POST['userlast'];
  $userEmail = $_POST['useremail'];

  if (empty($userFirst) || empty($userLast) || empty($userEmail)) {
    header("Location: ../profile.php?error=emptyfields&userfirst=".$userFirst."&userlast=".$userlast."&useremail=".$userEmail);
    exit();
  }
  else {
    $userObj->usersProfileUpdateInput($userId, $userFirst, $userLast, $userEmail);
  }
}

elseif (isset($_POST['pwd-update'])) {
  $userObj = new UsersControl();

  $userId = $_POST['uid'];
  $currentPwd = $_POST['current-pwd'];
  $newPwd = $_POST['new-pwd'];
  $confirmPwd = $_POST['confirm-new-pwd'];

  if (empty($currentPwd) || empty($newPwd) || empty($confirmPwd)) {
    header("Location: ../profile.php?error=emptyfield");
    exit();
  }
  elseif ($newPwd !== $confirmPwd) {
    header("Location: ../profile.php?error=newpwdnotmatch");
    exit();
  }
  else {
    $userObj->usersPwdUpdateInput($userId, $currentPwd,$newPwd);
  }
}

else {
  header("Location: ../dashboard.php");
}
