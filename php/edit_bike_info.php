<?php
    session_start();

        // function debug( $data ) {

        //     if ( is_array( $data ) )
        //         $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        //     else
        //         $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        //     echo $output;
        // }

  if(isset($_POST["bike_id"]) && is_numeric($_POST["bike_id"])){
    $bike = trim(strip_tags($_POST["bike_id"]));
    }
  
  if(isset($_POST["station"])){
    $value = trim(strip_tags($_POST["station"]));
  }
  

  $out = array(); 
  $out['first']   = $bike;
  $out['second']   = $value;

  // debug($bike);
  // debug($value);


  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  $mysqli->query("UPDATE Bikes SET current_station = \"$value\" WHERE bikeid = $bike");


  $err1 = $mysqli->error;
  print $err1;


  $mysqli->close();

  header("Location: bike_list.php");

?>