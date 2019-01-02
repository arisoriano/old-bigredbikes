<?php
    session_start();

  $station = $_GET["station"];
  $value = $_GET["value"];
  $text= $_GET["text"];

  $out = array(); 
  $out['first']   = $station;
  $out['second']   = $value;

  $set = 1;

  if ($value == "open"){
    $set = 0;
  }

  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }


  $mysqli->query("UPDATE Stations SET flagged = $set, flag_descript=".($text=='null'?"NULL":"\"$text\"")."  WHERE name = \"$station\"");

  $err1 = $mysqli->error;

  print $err1;

  $mysqli->close();

  echo json_encode($out);

?>