<?php
    session_start();
    include 'config.php';

    //Add a note
    if(isset($_POST["bike_id"])&&isset($_POST["comment"])){
        $bike= trim(strip_tags($_POST["bike_id"]));
        $note= trim(strip_tags($_POST["comment"]));
        $time=  date("Y-m-d H:i:s");
        $admin= $_SESSION['user'];
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $query= "INSERT INTO BikeNotes (bikeid, admin, note_text, timestamp) VALUES (?, ?, ?, '$time');";
        $stmt=$db->prepare($query);
        $stmt->bindParam(1, $bike);
        $stmt->bindParam(2, $admin);
        $stmt->bindParam(3, $note);
        $stmt->execute();

        $out=array();
        $out[0]= $bike;
        echo json_encode($out);

    }

    //Delete a note
    elseif(isset($_POST["note_id"])){
        $note= trim(strip_tags($_POST["note_id"]));
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($mysqli->errno) {
            print($mysqli->error);
            exit();
        }

        $out= array();
        $mysqli->query("DELETE FROM BikeNotes WHERE noteid = $note;");

        $err1 = $mysqli->error;
        print $err1;
    
        $mysqli->close();
        echo json_encode($out);       
    }

    //Get notes
    elseif(isset($_POST["bike_id"])){
        $bike= trim(strip_tags($_POST["bike_id"]));
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($mysqli->errno) {
            print($mysqli->error);
            exit();
        }

        $out= array();
        $i= 0;
        $result= $mysqli->query("SELECT * FROM BikeNotes WHERE bikeid = $bike;");
        while($row= $result->fetch_assoc()){
            $out[$i]= $row;
            $i++;
        }

        $err1 = $mysqli->error;
        print $err1;
    
        $mysqli->close();
        echo json_encode($out);

        //header("Location: bike_list.php");

    }

/*  if(isset($_POST["bike_id"]) && is_numeric($_POST["bike_id"])){
    $bike = trim(strip_tags($_POST["bike_id"]));
    } 

  if(isset($_POST["comment"])){
    $value = trim(strip_tags($_POST["comment"]));
    } 
  

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

  $err1 = $mysqli->error;
  print $err1;

  $mysqli->close();

  header("Location: bike_list.php");*/

?>