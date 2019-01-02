<?php
     function printName($result){
                              
              while ( $array = $result->fetch_assoc() ) {

                $name = $array['fname'].' '.$array['lname'];
            }
            
            echo "<p class='move_space'><span class='red_large'>&nbsp;&nbsp;Welcome,</span><span class='black'> $name </span></p>";
     }
             $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
      if ($mysqli->errno) {
          print($mysqli->error);
          exit();
      }

      //select all of the albums grouped by aid
        //$result = $mysqli->query("SELECT * FROM Album");
        $useremail = $_SESSION['user'];
        $result = $mysqli->query("SELECT * FROM BikeshareUsers WHERE email = '$useremail' ");
        
        // Print out all the photos (use printPhotos)
        printName($result);

        // Closing connection
        $mysqli->close();
      ?>