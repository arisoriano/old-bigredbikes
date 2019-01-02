<?php
    session_start();

  $user = $_GET["email"];

  $out = array(); 

  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  //select all of the albums grouped by aid
  //$result = $mysqli->query("SELECT * FROM Album");
  $result = $mysqli->query("SELECT * FROM `BikeshareUsers` WHERE email = \"$user\"");
    

  while ( $array = $result->fetch_assoc() ){
    $out['name'] = $array['fname'].' '.$array['lname'];
    $out['email'] = $array['email'];
  }

  $mysqli->close();

  echo json_encode($out);

?>