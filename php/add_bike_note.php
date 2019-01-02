<?php
    session_start();

   if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }
  $bike = $_POST["bikeid"];
  $value = $_POST["comment"];

  $out = array(); 
  $out['first']   = $bike;
  $out['second']   = $value;


  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }


  $mysqli->query("UPDATE Bikes SET flag_descript = \"$value\" WHERE bikeid = $bike");

  $mysqli->close();

  echo json_encode($out);

?>