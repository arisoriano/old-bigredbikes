<?php
  session_start();
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


  // debug("HERE");

  //   $user = strip_tags($_POST["user"]);
  //   $admin = strip_tags($_POST["admin"]);
  //   $station = strip_tags($_POST["station"]);
  //   $bike = strip_tags($_POST["bike"]);



            
  if (isset($_POST["user_out"]) && $_POST["user_out"] != "" &&
      isset($_POST["admin_out"]) && $_POST["admin_out"] != "" &&
      isset($_POST["station"]) && $_POST["station"] != "" &&
      isset($_POST["bike"]) && $_POST["bike"] != "") {

    $user = strip_tags($_POST["user_out"]);
    $admin = strip_tags($_POST["admin_out"]);
    $station = strip_tags($_POST["station"]);
    $bike = strip_tags($_POST["bike"]);
    $time= date("Y-m-d H:i:s");

    // debug("User: ".$user);
    // debug("Admin: ".$admin);
    // debug("Station: ".$station);
    // debug("Bike: ".$bike);
    // debug("Time: ".$time);


    $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD); 
    $query= "INSERT INTO Rentals (email, checkout_admin, rented_from, bikeid, time_rented) 
             VALUES (?, ?, ?, ?, ?);";
    $stmt= $db->prepare($query);
    $stmt->bindParam(1, $user);
    $stmt->bindParam(2, $admin);
    $stmt->bindParam(3, $station);
    $stmt->bindParam(4, $bike);
    $stmt->bindParam(5, $time);
    $stmt->execute();
    $result= $stmt->rowCount();

    if($result==0){
        echo '<p>You have encountered an error. '.$db->errorInfo().'</p>';
    }

    $rent_id = $db->lastInsertiD();

    //Update last rented for that bike
    $mysqli->query("UPDATE Bikes SET last_rented='$time', current_station=NULL WHERE bikeid=$bike;");

    // debug("Last ID: ".$rent_id);

    $mysqli->query("UPDATE BikeshareUsers SET rentalid = \"$rent_id\" WHERE email = \"$user\"");

    }

  $mysqli->close();

  header("Location: account.php");
?>