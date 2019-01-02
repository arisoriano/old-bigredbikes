<?php
    session_start();

        // function debug( $data ) {

        //     if ( is_array( $data ) )
        //         $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        //     else
        //         $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        //     echo $output;
        // }

  $name = $_POST["name"];
  $addr = $_POST["addr"];
  $hours = $_POST["hours_link"];

  $out = array(); 
  $out['first']   = $name;
  $out['second']   = $addr;
  $out['third']   = $hours;


  // debug($name);
  // debug($addr);
  // debug($hours);


  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  $mysqli->query("INSERT INTO Stations (name, address, hours_link) VALUES(\"$name\", \"$addr\", \"$hours\")");


  $err1 = $mysqli->error;
  print $err1;


  $mysqli->close();

  // echo json_encode($out);

  header("Location: stations.php");

?>