<?php
include 'autoloader.inc.php';

if (isset($_POST['role-assign'])) {

  $userSelect = $_POST['userselect'];
  $userRole = $_POST['userRole'];

  $userObj = new UsersControl();

  $userObj->usersRoleAssignInput($userSelect, $userRole);

}
else {
  header("Location: ../dashboard.php");
}
