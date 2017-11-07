<?php
  $servername = 'database';
  $username  = 'level4';
  $password = 'level4';
  $database = 'level4';
  $token = "TOKEN{edf65cdde5abaf16e4a7a5f378ee302c}";
  $nextChallenge = "/edf65cdde5abaf16e4a7a5f378ee302c.php";


  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Unable to connect to MYSQL server");
  }
?>
