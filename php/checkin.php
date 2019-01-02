<?php
  session_start();
   if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }
  function debug( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
  }

  include 'config.php';

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }


      $out = array(); 
      $out['1']   = $_POST["rental_id"];
      $out['2']   = $_POST["user_in"];
      $out['3']   = $_POST["admin_in"];
      $out['4']   = $_POST["late_options"];
      $out['5']   = $_POST["station"];
      $out['6']   = date("Y-m-d H:i:s");
      //echo json_encode($out);

      // debug("HERE1");

            
  if (isset($_POST["rental_id"]) && $_POST["rental_id"] != "" &&
      isset($_POST["user_in"]) && $_POST["user_in"] != "" &&
      isset($_POST["admin_in"]) && $_POST["admin_in"] != "" &&
      isset($_POST["late_options"]) && $_POST["late_options"] != "" &&
      isset($_POST["station"]) && $_POST["station"] != "") {

    // debug("HERE2");

    $rental_id = strip_tags($_POST["rental_id"]);
    $user = strip_tags($_POST["user_in"]);
    $admin = strip_tags($_POST["admin_in"]);
    $late_options = strip_tags($_POST["late_options"]);
    $station = strip_tags($_POST["station"]);
    $time=date("Y-m-d H:i:s");



    // debug($rental_id);


    $mysqli->query("UPDATE Rentals SET checkin_admin = \"$admin\", time_returned = '$time', returned_to = \"$station\" WHERE rentalid = $rental_id");

    $err1 = $mysqli->error;

    print $err1;

    $result= $mysqli->query("SELECT bikeid FROM Rentals WHERE rentalid=$rental_id;");
    $row= $result->fetch_row();
    $bike=$row[0];

    $mysqli->query("UPDATE BikeshareUsers SET rentalid = NULL WHERE email = \"$user\";");

    $err1 = $mysqli->error;
    print $err1;


    $mysqli->query("UPDATE Bikes SET current_station=\"$station\" WHERE bikeid=$bike;");

    $err1 = $mysqli->error;
    print $err1;


    }

  $mysqli->close();

  header("Location: account.php");
?>