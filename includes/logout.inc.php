<?php
    session_start();    //Start a session
    session_unset();    //Take all the session variable when you login and take all the userid/name are delete from the session variables
    session_destroy();  //Destroy the session we're running from the current website
    header("Location: ../index.php");   //Take person back from the front page
