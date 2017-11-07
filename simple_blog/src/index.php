<?php
  include("flag.php");
  $debug = strtolower($_SERVER['HTTP_X_DEBUG']) === 'true';
  header("X-Debug: " . ($debug ? 'true' : 'false'));

  if ($debug) {
    show_source(__FILE__);
    die();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Simple Blog</title>
        <link href="swatch/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/docs/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/docs/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="test/bootswatch.css" rel="stylesheet">
  </head>
  <body id="top" class="preview" data-spy="scroll" data-target=".subnav" data-offset="80">
<div class="container">
<!-- Masthead
================================================== -->
<header class="jumbotron subhead" id="overview">
  <div class="row">
    <div class="span6">
      <h1>
        <img src="img/test/7upspot.gif">
        <FONT COLOR="#FF0000">S</FONT>
        <FONT COLOR="#FF5A00">i</FONT>
        <FONT COLOR="#FFB400">m</FONT>
        <FONT COLOR="#FFff00">p</FONT>
        <FONT COLOR="#A5ff00">l</FONT>
        <FONT COLOR="#4Bff00">e</FONT>
        <FONT COLOR="#FF5A00">B</FONT>
        <FONT COLOR="#FFB400">l</FONT>
        <FONT COLOR="#FFff00">o</FONT>
        <FONT COLOR="#A5ff00">g</FONT>
      </h1>
      <p class="lead">The real challenges start here ;)</p>
      <table cellpadding="2" cellspacing="2">
        <tr>
          <td>
            <img src="img/test/ie_logo.gif">
          </td>
          <td>
            <img src="img/test/ns_logo.gif">
          </td>
          <td>
            <img src="img/test/noframes.gif">
          </td>
          <td>
            <img src="img/test/notepad.gif">
          </td>
        </tr>
      </table>
    </div>
    <div class="span6">
      <center>
        <img src="img/test/yahooweek.gif">
        <img src="img/test/community.gif">
        <img src="img/test/wabwalk.gif">
        <img src="img/test/webtrips.gif">
      </center>
    </div>
  </div>
  <marquee>01000011 01101111 01101110 01100111 01110010 01100001 01110100 01111010 00101100 00100000 01111001 01101111 01110101 00100000 01101011 01101110 01101111 01110111 00100000 01100010 01101001 01101110 01100001 01110010 01111001 00101110 00100000 01000010 01110101 01110100 00100000 01001001 00100000 01110111 01101111 01110101 01101100 01100100 00100000 01101110 01100101 01110110 01100101 01110010 00100000 01110000 01110101 01110100 00100000 01100001 00100000 01100110 01101100 01100001 01100111 00100000 01101000 01100101 01110010 01100101 00100000 01110011 01101101 01101000 00101110 00101110 00101110 00100000 01011001 01101111 01110101 01110010 00100000 01100110 01101100 01100001 01100111 00100000 01101001 01110011 00100000 01110011 01101111 01101101 01100101 01110111 01101000 01100101 01110010 01100101 00100000 01100101 01101100 01110011 01100101 00101110</marquee>
</header>

<!-- Typography
================================================== -->
<section id="typography" style="padding-top: 0">
  <div class="page-header">
    <h1>My new blog</h1>
  </div>

  <!-- Headings & Paragraph Copy -->
  <div class="row">
    <img src="/img/chat.gif">
    <img src="/img/pzw4C8l.gif">
  </div>

  <p>I hope you guys like my website. I put a lot of effort into it.</p>
  <center>
    <?php
      if ($_GET['i_want_a'] == 'flag') {
        echo $flag;
        echo "<br><img src='img/cat.jpg'>";
      }
    ?>
  </center>

</section>

<br><br>
<center><img src="img/test/construction.gif"></center>

<br><br><br>
<center>
  <!-- TRIPLE MC HAMMER -->
  <img src="img/test/mchammer.gif">&nbsp;&nbsp;
  <img src="img/test/mchammer.gif">&nbsp;&nbsp;
  <img src="img/test/mchammer.gif">
</center>

<br><br><br><br>

     <!-- Footer
      ================================================== -->
      <footer class="footer">
        <p class="pull-left" style="margin-top: -14px"><img src="img/test/geocities.jpg"></p>
        <p class="pull-right" style="margin-top: -14px"><img src="img/test/hacker.gif">&nbsp; Built with <a href="http://bootswatch.com">Bootswatch</a></p>
      </footer>
 <center><img src="img/test/counter2.gif"></center>
    </div><!-- /container -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="bootstrap/docs/assets/js/jquery.js"></script>
    <script src="bootstrap/docs/assets/js/google-code-prettify/prettify.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-transition.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-alert.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-modal.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-tab.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-popover.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-button.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-typeahead.js"></script>
    <script src="bootstrap/docs/assets/js/bootstrap-affix.js"></script>
    <script src="bootswatch.js"></script>


  </body>
</html>
