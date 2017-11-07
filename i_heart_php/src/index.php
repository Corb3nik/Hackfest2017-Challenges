<?php
  error_reporting(0);
  if (isset($_GET['source'])) {
    show_source(__FILE__);
    die();
  }
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>I <3 PHP</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
      body, html {
        height: 100%;
        background-color: #FF0DFF;
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

      .corb-php {
        max-width: 50%;
      }
    </style>
   <meta charset="UTF-16">
  </head>
  <body>
    <div class="corb-centered corb-php text-center">
      <h1>I ❤ PHP</h1>
      <h3>❤ Here is a little
        <a target="_blank" href="/index.php?source">sandbox</a>
          I made demonstrating the powers of PHP. ❤
      </h3>
      <h3>
        Start here : <a href="/index.php?code=echo 'hello world';">Hello World</a>
      </h3>

      <div class="text-left">
        <h3>Output : </h3>
        <pre><code><?php
        if (isset($_GET['code'])) {
          $new_func = create_function('', $_GET['code']);

          // I will only run your code if it's "echo 'hello world';"
          // This way, you can't hurt my server with your evil stuff.
          if ($_GET['code'] === "echo 'hello world';") {
            $new_func();
          }
        }
        ?></code></pre>
      </div>
      <h3>Brought to you by <img style="width: 100px;" src="/img/php.svg"></h3>
    </div>

  </body>
</html>
