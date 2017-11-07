<?php
  session_start();
  error_reporting(0);

  require("./httprequest.php");
  require("./flag.php");

  function validate($question, $answer) {
      $url = "http://127.0.0.1/$question.php?answer=$answer";
      $r = new HTTPRequest($url);

      $response = $r->DownloadToString();
      $headers = $response->get_headers();
      $body = $response->get_body();

      if (stripos($body, "400 Bad Request") !== False ||
          stripos($body, "404 Not Found") !== False)
      {
        die("Hacker detected :/ What are you doing...");
      }

      return stripos($body, "The flagkeeper says yes.") !== False;
  }

  if (isset($_GET['question']) && isset($_GET['answer'])) {

    if ($_GET['question'] === "question1") {
      if (validate("question1", $_GET['answer'])) {
        $_SESSION['question1'] = True;
        echo "You've answered question 1 correctly.\n";
      } else {
        echo "The flagkeeper refuses your answer.\n";
      }
    }

    if ($_GET['question'] === "question2") {
      if (validate("question2", $_GET['answer'])) {
          $_SESSION['question2'] = True;
          echo "You've answered question 2 correctly.\n";
      } else {
        echo "The flagkeeper refuses your answer.\n";
      }
    }

    if ($_GET['question'] === "question3") {
      if (validate("question3", $_GET['answer'])) {
          $_SESSION['question3'] = True;
          echo "You've answered question 3 correctly.\n";
      } else {
        echo "The flagkeeper refuses your answer.\n";
      }
    }

    if ($_SESSION['question1'] and
        $_SESSION['question2'] and
        $_SESSION['question3']) {
        echo "Congratz :) Here is your flag : $flag";
    }
  }
?>
