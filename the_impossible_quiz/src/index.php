<?php
  session_start();
  error_reporting(0);
?>

<!DOCTYPE HTML>

<html>
  <head>
    <title>The Impossible Quiz</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
      body, html { height: 100%; background-color: black; }
      label, h1, h2, h3, h4, h5, h6 { color: white; }

      .corb-centered {
        position: relative;
        left: 50%;

        /* bring your own prefixes */
        transform: translate(-50%, 25%);
      }

      .solved {
        color: green;
      }

      .corb-php-impossible {
        max-width: 50%;
      }

      .corb-big-ass-button {
        width: 50%;
      }
    </style>
   <meta charset="UTF-16">
  </head>
  <body>
    <div class="corb-centered corb-php-impossible text-center">
      <h1>Welcome to the Impossible Quiz</h1>
      <h2>Your challenge is to correctly answer these 3 questions.</h2>
      <h3>But ...</h3>
      <h3>I've designed this so that it's literally impossible to finish.</h3>
      <h4>I'm confident that you won't solve it, so here's the <a href="./source.zip">source code</a>.</h4>

      <br/>
      <br/>
      <?php
        if (isset($_GET['msg'])) {
      ?>
      <div class="alert alert-info">
        <?php echo htmlentities($_GET['msg']); ?>
      </div>
      <?php
        }
      ?>

      <form onsubmit="validate('question1', this.answer.value); return false">
        <h3 id="question3" class="<?php if ($_SESSION['question1']) echo "solved"?>">Question 1 : What is your name?</h3>
        <label>Answer :&nbsp;&nbsp;&nbsp;</label>
        <input name="answer" type="text" class="form-control">
        <br/>
        <input type="submit" class="btn btn-submit btn-success">
      </form>

      <form onsubmit="validate('question2', this.answer.value); return false">
        <h3 id="question3" class="<?php if ($_SESSION['question2']) echo "solved"?>">Question 2 : What is your quest?</h3>
        <label>Answer :&nbsp;&nbsp;&nbsp;</label>
        <input name="answer" type="text" class="form-control">
        <br/>
        <input type="submit" class="btn btn-submit btn-success">
      </form>

      <form onsubmit="validate('question3', this.answer.value); return false">
        <h3 id="question3" class="<?php if ($_SESSION['question3']) echo "solved"?>">Question 3 : What...is the airspeed velocity of an unladen swallow?</h3>
        <label>Answer :&nbsp;&nbsp;&nbsp;</label>
        <input name="answer" type="text" class="form-control">
        <br/>
        <input type="submit" class="btn btn-submit btn-success">
      </form>

      <br/>
      <br/>
      <br/>
    </div>
    <script>
      function validate(question, answer) {
        url = "/api.php?question=" + question + "&answer=" + encodeURI(encodeURI(answer))
        var req = new XMLHttpRequest();
        req.onreadystatechange = function() {
                if(req.readyState != 4) return;
                if(req.status != 200) return;
                document.location = "/?msg=" + req.responseText
        }
        req.open("GET", url);
        req.send();
      }
    </script>
  </body>
</html>
