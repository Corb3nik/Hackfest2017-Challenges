<?php
  session_start();
  header("Location: /");
  $_SESSION['logged_in'] = false;
?>
