<?php
    session_start();

  $email = $_GET["email"];
  $value = $_GET["value"];

  $out = array(); 
  $out['first']   = $email;
  $out['second']   = $value;


  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  $mysqli->query("UPDATE BikeshareUsers SET status = \"$value\" WHERE email = \"$email\"");

  $mysqli->close();

  echo json_encode($out);

?>