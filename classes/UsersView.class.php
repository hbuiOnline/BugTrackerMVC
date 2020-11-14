<?php

class UsersView extends Users {

  public function usersDataShow(){
    $result = $this->usersData();
    echo $result;
  }

  public function usersNameShow(){
    $result = $this->usersName();
    echo $result;
  }

  public function usersDetailShow($userId){
    $result = array();
    $result = $this->usersDetail($userId);
    return $result;
  }

}
