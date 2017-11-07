<?php
  if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
    die("Direct access forbidden");
  }

  // I WILL NEVER LET YOU PASS
  die("The flagkeeper says nope :/");
?>
