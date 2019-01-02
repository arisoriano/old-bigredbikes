<?php
    session_start();

  if (isset($_POST["addr2"])){
    $addr = trim(strip_tags($_POST["addr2"]));
  }
  
  if (isset($_POST["hours_link2"])){
    $hours = trim(strip_tags($_POST["hours_link2"]));
  }
  
  if (isset($_POST["bikes"]) && is_numeric($_POST["bikes"])){
    $bikes = trim(strip_tags($_POST["bikes"]));
  }
  
  if (isset($_POST["helmets"]) && is_numeric($_POST["helmets"])){
    $helmets = trim(strip_tags($_POST["helmets"]));
  }
  
  if (isset($_POST["locks"]) && is_numeric($_POST["locks"])){
    $locks = trim(strip_tags($_POST["locks"]));
  }
  
  if (isset($_POST["name"])){
    $name = trim(strip_tags($_POST["name"]));
  }
  

  $out = array(); 
  $out['first']   = $addr;
  $out['second']   = $hours;
  $out['third']   = $bikes;
  $out['fourth']   = $helmets;
  $out['fifth']   = $locks;
  $out['name']   = $name;



  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  $mysqli->query("UPDATE Stations SET address=\"$addr\", hours_link=\"$hours\", num_bikes=\"$bikes\", num_helmets=\"$helmets\", num_bikelocks=\"$locks\"  WHERE name = \"$name\"");


  $err1 = $mysqli->error;
  print $err1;


  $mysqli->close();

  echo json_encode($out);

  header("Location: stations.php");

?>