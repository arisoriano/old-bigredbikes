<?php
    session_start();

  if(isset($_POST['name'])){
    $station = trim(strip_tags($_POST["name"]));
  }
  
  if(isset($_POST['comment'])){
    $value = trim(strip_tags($_POST["comment"]));
  }
  

  $out = array(); 
  $out['first']   = $station;
  $out['second']   = $value;


  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }


  $mysqli->query("UPDATE Stations SET flag_descript = \"$value\" WHERE name = \"$station\"");

  $err1 = $mysqli->error;

  print $err1;

  $mysqli->close();

  echo json_encode($out);

  header("Location: stations.php");

?>