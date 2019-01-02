<?php
    session_start();

    if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }
  $station = $_GET["station"];

  // $out = array(); 
  // $out['first']   = $station;

  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  $mysqli->query("DELETE FROM Stations WHERE name = \"$station\"");


  $err1 = $mysqli->error;
  print $err1;


  $mysqli->close();
  echo json_encode($out);

?>