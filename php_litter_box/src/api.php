<?php
  session_start();

  if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = array();
  }

  function addDung() {
    $x = rand(1, 100);
    $y = rand(1, 100);
    $item = array();
    $item['x'] = $x;
    $item['y'] = $y;
    $item['type'] = "dung";
    array_push($_SESSION['items'], $item);
    echo json_encode($item);
  }

  function addCat() {
    $x = rand(1, 100);
    $y = rand(1, 100);
    $item = array();
    $item['x'] = $x;
    $item['y'] = $y;
    $item['type'] = "cat";
    array_push($_SESSION['items'], $item);
    echo json_encode($item);
  }

  function items() {
    echo json_encode($_SESSION['items']);
  }

  $blacklist = ["exec", "passthru", "system", "shell_exec", "`", "popen", "proc_open", "pcntl_exec", "eval", "assert", "include", "require", ".", '"', "'", "glob"];

  if (isset($_GET['action'])) {
    $_GET['action'] = substr($_GET['action'], 0, 17);
    foreach ($blacklist as $black) {
      if (stripos($_GET['action'], $black) !== False) {
        die("Malicious keyword detected : " . $black);
      }
    }
    eval($_GET['action'] . "();");
  }
?>
