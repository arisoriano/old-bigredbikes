<?php
    session_start();

  $bike = $_GET["bike"];
  $value = $_GET["value"];
  $flag= $_GET["flag"];

  $out = array(); 
  $out['first']   = $bike;
  $out['second']   = $value;

  $set = 1;

  if ($value == "ok"){
    $set = 0;
  }

  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }


  $mysqli->query("UPDATE Bikes SET flagged = $set, flag_descript=".($flag=='null'?"NULL":"\"$flag\"")." WHERE bikeid = $bike");

  $mysqli->close();

  echo json_encode($out);

?>