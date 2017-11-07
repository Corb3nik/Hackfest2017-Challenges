<?php

error_reporting(0);
require("conf/index.conf.php");

?>

<!DOCTYPE HTML>
<html>
  <head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body>
    <div id="custom-bootstrap-menu" class="navbar navbar-default " role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Baby SQLi</a>
          <button type="button" class="navbar-toggle"
                  data-toggle="collapse"
                  data-target=".navbar-menubuilder">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
          <ul class="nav navbar-nav navbar-left">
            <li><a href="#">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="text-center">
        <div>
          <h1>Welcome to Baby SQLi</h1>
          <h3>Goal : Finish all 5 levels to obtain your flag.</h3>
          <h4>Each level contains a hidden <code>TOKEN{...}</code> token
              which you will use to proceed to the next level.
          </h4>
        </div>
        <hr/>
        <div>
          <?php
            if (isset($_POST['token'])) {
              $isValid = str_replace(' ', '', $_POST['token']) === $token;
              if (!$isValid) {
                echo '<div class="alert alert-danger">Invalid token!</div>';
              } else {
                echo "<div class=\"alert alert-success\">Good job! Next level :<a href=\"$nextChallenge\">$nextChallenge</a> </div>";
                die();
              }
            }
          ?>
          <h2>Ready to begin?</h2>
          <h3>Here's your first token :
            <code>TOKEN{41633f246db7935ae490abcef7a72eb0}</code>
          </h3>
        </div>
        <hr/>
        <div>
          <h2>Submit token</h2>
          <form method="POST" style="width: 50vw; margin:auto">
            <input name="token" type="text"
                   class="form-control"
                   placeholder="Submit your token here...">
            <br/>
            <input type="submit" value="Submit" class="form-control">
          </form>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
