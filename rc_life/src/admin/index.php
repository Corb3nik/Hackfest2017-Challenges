<?php
  error_reporting(0);
  session_start();
  if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'rclifewootwoot') {
      $_SESSION['logged_in'] = true;
    } else {
      $_SESSION['logged_in'] = false;
      $msg = 'Invalid username/password';
    }
  }

  if ($_SESSION['logged_in']) {
    if (!isset($_GET['next'])) {
      $_GET['next'] = '898111356132e7d5961b6c194be49291.php';
    }
    include($_GET['next']);
    die();
  }
?>

<html>
  <head>
    <!-- All the files that are required -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  </head>

  <body>
    <!-- Where all the magic happens -->
    <!-- LOGIN FORM -->
    <div style="text-align:center" class="text-center" style="padding:50px 0">
      <div class="logo">login</div>

      <?php
          if (isset($msg)) {
            echo "<div style='color: red;'>$msg</div>";
          }
      ?>
      <!-- Main Form -->
      <div class="login-form-1">
        <form method="POST" id="login-form" class="text-left">
          <div class="login-form-main-message"></div>
          <div class="main-login-form">
            <div class="login-group">
              <div class="form-group">
                <label for="lg_username" class="sr-only">Username</label>
                <input type="text" class="form-control" id="lg_username" name="username" placeholder="username">
              </div>
              <div class="form-group">
                <label for="lg_password" class="sr-only">Password</label>
                <input type="password" class="form-control" id="lg_password" name="password" placeholder="password">
              </div>
            </div>
            <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
          </div>
        </form>
      </div>
      <!-- end:Main Form -->
    </div>
  </body>
</html>

