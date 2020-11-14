<?php

use PhpRbac\Rbac;

class RolesPermissions extends Dbh {

  protected function roleCreate($roleTitle, $roleDescription){

    require '../vendor/autoload.php';
    $rbac = new Rbac();

    //Need to validate if the role has been created in the database using all lower cases
    $role_id = $rbac->Roles->add($roleTitle, $roleDescription);
    header("Location: ../rolepermission.php?rolecreate=success");
    exit();

  }//End of roleCreate()

  protected function permissionCreate($permissionTitle, $permissionDescription){

    require '../vendor/autoload.php';
    $rbac = new Rbac();

    $perm_id = $rbac->Permissions->add($permissionTitle, $permissionDescription);
    header("Location: ../rolepermission.php?permissioncreate=success");
    exit();
  }//End of permissionCreate()

  protected function userRoleAssign($userSelect, $userRole){

    require '../vendor/autoload.php';
    $rbac = new Rbac();

    $rbac->Users->assign($userRole, $userSelect);

    $sql = "UPDATE users SET usersRole = ? WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../rolepermission.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userRole, $userSelect]);
    }

    header("Location: ../rolepermission.php?userroleassign=success");
    exit();

  }//End of userRoleAssign()

  protected function userRoleUnassign($userRole, $userSelect){
    require '../vendor/autoload.php';
    $rbac = new Rbac();
    $rbac->Users->unassign($userRole, $userSelect);

    $sql = "UPDATE users SET usersRole = NULL WHERE idUsers = ?;";
    $stmt = $this->connect()->prepare($sql);
    if (!$stmt) {
      header("Location: ../rolepermission.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute([$userSelect]);
      header("Location: ../rolepermission.php?userroleunassign=success");
      exit();
    }

  } // End of userRoleUnassign

  protected function roleData(){

    $roleData = "";
    $sql = "SELECT * FROM phprbac_roles;";

    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../rolepermission.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $roleData .=
        "<tr>
          <td>".$row['Title']."</td>"
          ."<td>".$row['Description']."</td>
        </tr>";
      }
    }
    return $roleData;
  }//End roleData()

  protected function permissionData(){

    $permData = '';
    $sql = "SELECT * FROM phprbac_permissions;";

    $stmt = $this->connect()->query($sql);
    if (!$stmt) {
      header("Location: ../rolepermission.php?error=sqlerror");
      exit();
    }
    else {
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $permData .=
        "<tr>
          <td>".$row['Title']."</td>"
          ."<td>".$row['Description']."</td>
        </tr>";
      }
      return $permData;
    }

  }//End of permissionData()

  protected function userRoleData(){
    $userRoleData = '';
    $extraSpace = 'btn-danger';

    $sql = "SELECT U.idUsers ,U.usersFirst, U.usersLast, R.Title, R.ID as RoleID
            FROM users U, phprbac_roles R, phprbac_userroles UR
            WHERE UR.UserID = U.idUsers AND UR.RoleID = R.ID;";

    $stmt = $this->connect()->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $userRoleData .=
      "<tr>
        <td>".$row['usersFirst']." ".$row['usersLast']."</td>"
        ."<td>".$row['Title']."</td>"

        ."<td><a href="."#"." data-toggle="."modal"." data-target="."#roleeditassignmodal".">Reassign</a>

        <br>

        <form class="."user"." action="."includes/rolepermission.inc.php"." method="."POST".">
        <input type="."hidden"." value=".$row['idUsers']." name="."userselect"."></input>
        <input type="."hidden"." value=".$row['RoleID']." name="."userrole"."></input>
        <button class="."btn-danger"." type="."submit"." name="."role-unassign".">Unassign</button>
        </form></td>

      </tr>";
    }
    return $userRoleData;
  }// End of userRoleData()

  protected function roleTitleAssign(){

    $sql = "SELECT * FROM phprbac_roles;";
    $stmt = $this->connect()->query($sql);
    $roleTitle = "";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $roleTitle .= "<option value=".$row['ID'].">".$row['Title']."</option>";
    }

    return $roleTitle;

  }//End of roleTitle()




}
