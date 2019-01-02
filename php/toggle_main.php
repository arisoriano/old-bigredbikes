<?php
    session_start();
    if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }

  $value = $_GET["value"];

  $out = array(); 
  $out['first']   = $value;

  $set = 0;

  if ($value == "open"){
    $set = 1;
  }

  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }


  $mysqli->query("UPDATE Status SET open = $set WHERE name = \"all\"");

  $err1 = $mysqli->error;

  print $err1;

  $mysqli->close();

  echo json_encode($out);

?>