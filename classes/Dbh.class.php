<?php

class Dbh {
  private $host = "localhost";
  private $username = "root";
  private $password = "";
  private $dbName = "bugtracker";

  protected function connect(){
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;  //Database sort name
    $pdo = new PDO($dsn, $this->username, $this->password );  //PDO is the connection type of database
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }
}
