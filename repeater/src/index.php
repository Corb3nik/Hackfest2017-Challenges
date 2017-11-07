<?php
  $showFlag = $_SERVER['REQUEST_METHOD'] === 'BURPSUITE' &&
  $_SERVER['HTTP_X_FLAG'] === 'true';

  if ($showFlag) {
?>

// Congratulations!

// There are 3 things to take away from this challenge.

// 1. There is such a thing called HTTP headers
// 2. There is such a thing called HTTP methods/verbs
// 3. Use Burpsuite, it'll be your best friend when doing web app security :)

HF-722011233aade2887366ab43848521a7

// ...

// If you didn't use Burpsuite for this challenge :
// https://portswigger.net/burp/help/suite_gettingstarted.html

<?php
  } else {
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Repeater</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
      body, html {
        height: 100%;
        background-color: #ff6633;
        color: black;
      }

      .corb-centered {
        position: relative;
        left: 50%;

        /* bring your own prefixes */
        transform: translate(-50%, 25%);
        background-color: white;
        padding: 20px;
        border: 2px solid black;
        border-radius: 25px;
      }

      .corb-repeater {
        max-width: 50%;
      }

      .corb-big-ass-button {
        width: 50%;
      }
    </style>
   <meta charset="UTF-16">
  </head>
  <body>
    <div class="corb-centered corb-repeater text-center">

      <h1>Repeater</h1>

      <br/>
      <h3>This challenge is quite simple.</h3>
      <br/>
      <h3>Send me a request with the following specifications :</h3>
      <br/>
        <h4>HTTP method/verb has to be <code>BURPSUITE</code></h4>
        <h4>A header <code>X-Flag</code> with a value of <code>true</code></h4>
      <br/>
      <h3>... and a magical flag will appear ;)</h3>
    </div>
  </body>
</html>
<?php } ?>

