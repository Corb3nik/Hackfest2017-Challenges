<?php
  $servername = 'database';
  $username  = 'level3';
  $password = 'level3';
  $database = 'level3';
  $token = "TOKEN{81fbb5f37be58266f89dc381f62890ef}";
  $nextChallenge = "/81fbb5f37be58266f89dc381f62890ef.php";


  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Unable to connect to MYSQL server");
  }
?>
