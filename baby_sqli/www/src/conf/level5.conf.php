<?php
  $servername = 'database';
  $username  = 'level5';
  $password = 'level5';
  $database = 'level5';
  $token = "TOKEN{aca23600d45ffd33a07dddd0668d04b1}";
  $flag = "HF-aca23600d45ffd33a07dddd0668d04b1";


  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
      die("Unable to connect to MYSQL server");
  }
?>
