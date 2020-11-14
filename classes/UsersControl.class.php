<?php

class UsersControl extends Users {

  //Properties

  public function validateUserInput($userFirst, $userLast, $username, $userEmail,  $userPwd, $confirmPwd){

    if(empty($userFirst) || empty($userLast) || empty($username) || empty($userEmail) || empty($userPwd) || empty($confirmPwd)){
        header("Location: ../signup.php?error=emptyfield&uid=".$username."&mail=".$userEmail);
        exit();
    }
    elseif(!filter_var($userEmail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invalidemailuid");
        exit();
    }
    elseif(!filter_var($userEmail, FILTER_VALIDATE_EMAIL)){ //This use to check if the email is valid
        header("Location: ../signup.php?error=invalidemail&uid=".$username);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invaliduid&mail=".$userEmail);
        exit();
    }
    elseif($userPwd !== $confirmPwd){ //Check if the password and confirm are match
        header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$userEmail);
        exit();
    }
    else {
      $this->validateUserCreate($userFirst, $userLast, $userEmail, $username, $userPwd);
    }

  } //End of validateUserInput

  public function userLoginInput ($mailUser, $userPwd){
    if (empty($mailUser) || empty($userPwd)) {
      header("Location: ../index.php?error=emptyfields");
      exit();
    }
    else {
      $this->userLogin($mailUser, $userPwd);
    }
  }//end of userLoginInput

  public function demoUserLoginInput($demoUsername){
    if (empty($demoUsername)) {
      header("Location: ../index.php?error=emptyfields");
      exit();
    }
    else {
      $this->demoUserLogin($demoUsername);
    }
  }//End demoUserLoginInput

  public function userResetPwdInput($userEmail){

    if (empty($userEmail)) {
      header("Location: ../reset-password.php?error=emptyfield");
      exit();
    }
    else {
      $this->userResetPwd($userEmail);
    }
  }//End of userResetPwdInput

  public function userResetPwdEmailInput($userEmail){
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) { //This use to check if the email is valid
      header("Location: ../reset-password.php?error=invalidemail");
      exit();
    }
    elseif (empty($userEmail)) {
      header("Location: ../reset-password.php?error=emptyfield");
      exit();
    }
    else {
      $this->userResetPwdEmail($userEmail);
    }
  } //End userResetPwdEmailInput

  public function usersRoleAssignInput($userSelect, $userRole){
    $this->usersRoleAssign($userSelect, $userRole);
  }//End of usersRoleAssignInput

  public function usersProfileUpdateInput($userId, $userFirst, $userLast, $userEmail){
    $this->usersProfileUpdate($userId, $userFirst, $userLast, $userEmail);
  }

  public function usersPwdUpdateInput($userId ,$currentPwd, $newPwd){
    $this->usersPwdUpdate($userId ,$currentPwd, $newPwd);
  }





}
