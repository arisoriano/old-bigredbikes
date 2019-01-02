<?php
session_start();

  function debug( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
  }

unset($_SESSION['user'] );
unset($_SESSION['lvl'] );
unset( $_SESSION );
$_SESSION = array();
session_destroy();


header("Location: index.php");

?>
