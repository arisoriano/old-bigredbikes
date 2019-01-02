<?php
    session_start();

        // function debug( $data ) {

        //     if ( is_array( $data ) )
        //         $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        //     else
        //         $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        //     echo $output;
        // }

  $bike = $_POST["bike_id"];
  $station = $_POST["station"];
  $time= date("Y-m-d h:i:s");

  $out = array(); 
  $out['first']   = $bike;
  $out['second']   = $station;


  // debug($bike);
  // debug($station);


  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  $mysqli->query("INSERT INTO Bikes (bikeid, date_added, current_station) VALUES($bike, \"$time\", \"$station\")");


  $err1 = $mysqli->error;
  print $err1;


  $mysqli->close();

  // echo json_encode($out);

  header("Location:bike_list.php");
  exit;

?>