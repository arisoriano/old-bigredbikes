<?php
    session_start();
   if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }

  $id = $_GET["id"];
  $email = $_GET["email"];

  $out = array(); 

  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  //select all of the albums grouped by aid
  //$result = $mysqli->query("SELECT * FROM Album");
  $result = $mysqli->query("  SELECT * FROM BikeshareUsers B INNER JOIN Rentals C ON B.email=C.email WHERE C.rentalid = \"$id\"");


  while ( $array = $result->fetch_assoc() ){
    $name = $array['fname'].' '.$array['lname'];
    $out['bikeid'] = $array['bikeid'];
    $date = new DateTime($array['time_rented']);
    $out['time_rented'] = $date->format('m-d-Y h:i:sa');
    $out['checkout_admin'] = $name." (".$array['checkout_admin'].")";
    $out['rented_from'] = $array['rented_from'];
  }



  $mysqli->close();

  echo json_encode($out);

?>