<?php
    include 'config.php';
    session_start();

    if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }


    $station=$_GET['station'];
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    

    if ($mysqli->errno) {
        print($mysqli->error);
        exit();
    }

    $out= array();
    $i= 0;
    $result= $mysqli->query("SELECT bikeid FROM Bikes WHERE current_station=\"$station\" AND flagged=0;");
    
    while($row= $result->fetch_assoc()){
        $out[$i]= $row['bikeid'];
        $i++;
    }

    $err1 = $mysqli->error;
    print $err1;
    
    $mysqli->close();
    echo json_encode($out);

    //header("Location: account.php");

?>