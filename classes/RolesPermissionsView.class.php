<?php

class RolesPermissionsView extends RolesPermissions {

  public function roleDataShow(){
    $result = $this->roleData();
    echo $result;
  }

  public function permissionDataShow(){
    $result = $this->permissionData();
    echo $result;
  }

  public function roleTitleAssignShow(){
    $result = $this->roleTitleAssign();
    echo $result;
  }

  public function userRoleDataShow(){
    echo $this->userRoleData();
  }
}
