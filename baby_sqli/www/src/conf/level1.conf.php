<?php
  $servername = 'database';
  $username  = 'level1';
  $password = 'level1';
  $database = 'level1';
  $token = "TOKEN{27ad9e262cdb63fa072ef4457a20526b}";
  $nextChallenge = "/27ad9e262cdb63fa072ef4457a20526b.php";


  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Unable to connect to MYSQL server");
  }
?>
