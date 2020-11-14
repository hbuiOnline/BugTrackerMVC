<?php

class RolesPermissionsControl extends RolesPermissions {

  public function roleCreateInput($roleTitle, $roleDescription){
    $this->roleCreate($roleTitle, $roleDescription);
  }

  public function permissionCreateInput($permissionTitle, $permissionDescription){
    $this->permissionCreate($permissionTitle, $permissionDescription);
  }

  public function userRoleAssignInput($userSelect, $userRole){
    $this->userRoleAssign($userSelect, $userRole);
  }

  public function userRoleUnassignInput($userRole, $userSelect){
    $this->userRoleUnassign($userRole, $userSelect);
  }

}
