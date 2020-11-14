<?php

class TicketsView extends Tickets {

  public function ticketDataShow($userId){
    $result = array(array());
    $result = $this->ticketData($userId);
    return $result; //This is 2D array
  }

  public function ticketDataInProjectShow($projectId){
    $result = $this->ticketDataInProject($projectId);
    echo $result;
  }

  public function ticketDetailShow($ticketId){
    $result = array();
    $result = $this->ticketDetail($ticketId);
    return $result;
  }

  public function ticketCommentDataShow($ticketId){
    $result = $this->ticketCommentData($ticketId);
    echo $result;
  }

  public function ticketHistoryDataShow($ticketId){
    $result = $this->ticketHistoryData($ticketId);
    echo $result;
  }

  public function ticketStatusCountShow(){
    $result = array();
    $result = $this->ticketStatusCount();
    return $result;
  }

  public function ticketPriorityCountShow(){
    $result = array();
    $result = $this->ticketPriorityCount();
    return $result;
  }

  public function ticketTypeCountShow(){
    $result = array();
    $result = $this->ticketTypeShow();
    return $result;
  }

}
