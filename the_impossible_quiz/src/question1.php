<?php
  if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
    die("Direct access forbidden");
  }

  if (isset($_GET['answer']) and $_GET['answer'] === 'King Arthur of the Britons') {
     die("The flagkeeper says yes.");
  }

  die("The flagkeeper says nope :/");
?>
