<?php

include 'autoloader.inc.php';

if (isset($_POST['role-create'])) {

  $roleTitle = $_POST['roletitle'];
  $roleDescription = $_POST['roledescription'];

  $roleObj = new RolesPermissionsControl();
  $roleObj->roleCreateInput($roleTitle, $roleDescription);

}

elseif (isset($_POST['permission-create'])) {

  $permissionTitle = $_POST['permissiontitle'];
  $permissionDescription = $_POST['permissiondescription'];

  $permissionObj = new RolesPermissionsControl();
  $permissionObj->permissionCreateInput($permissionTitle, $permissionDescription);
}

elseif (isset($_POST['role-assign'])) {

  $userSelect = $_POST['userselect'];
  $userRole = $_POST['userrole'];

  $userRoleObj = new RolesPermissionsControl();
  $userRoleObj->userRoleAssignInput($userSelect, $userRole);
}

elseif (isset($_POST['role-unassign'])) {

  $userSelect = $_POST['userselect'];
  $userRole = $_POST['userrole'];

  $userRoleObj = new RolesPermissionsControl();

  $userRoleObj->userRoleUnassignInput($userRole, $userSelect);
}


else {
  header("Location: ../dashboard.php");
}
