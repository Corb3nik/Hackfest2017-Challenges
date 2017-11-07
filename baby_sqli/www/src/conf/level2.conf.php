<?php
  $servername = 'database';
  $username  = 'level2';
  $password = 'level2';
  $database = 'level2';
  $token = "TOKEN{3de29c4befd158c9bb98570d9b8a052d}";
  $nextChallenge = "/3de29c4befd158c9bb98570d9b8a052d.php";


  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Unable to connect to MYSQL server");
  }
?>
