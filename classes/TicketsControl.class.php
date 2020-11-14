<?php

class TicketsControl extends Tickets {

  public function ticketCreateInput ($ticketTitle, $ticketDescription, $ticketType, $ticketPriority,$ticketStatus,$ticketProjectId, $userId){
    $this->ticketCreate($ticketTitle, $ticketDescription, $ticketType, $ticketPriority,$ticketStatus,$ticketProjectId, $userId);
  }

  public function ticketCommentInput($ticketId, $ticketCommenter, $ticketMessage){
    $this->ticketComment($ticketId, $ticketCommenter, $ticketMessage );
  }

  public function ticketUpdateInput($ticketId, $ticketTitle, $ticketDescription, $ticketDeveloper, $ticketPriority,$ticketStatus, $ticketProjectId, $ticketType){
    $this->ticketUpdate($ticketId, $ticketTitle, $ticketDescription, $ticketDeveloper, $ticketPriority,$ticketStatus, $ticketProjectId, $ticketType);
  }
  public function ticketHistoryUpdateInput($ticketNewValue, $ticketId){
    $this->ticketHistoryUpdate($ticketNewValue, $ticketId);
  }
}
