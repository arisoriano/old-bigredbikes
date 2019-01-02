      <?php
        function printMyTrips($result){
                              
              while ( $array = $result->fetch_assoc() ) {

                $rented = $array['time_rented'];
                $returned = $array['time_returned'];
                $diff= abs(strtotime($returned)-strtotime($rented));
              
            
            if(is_null($returned) || is_null($rented)){
                    $hours= "";
                    $minutes= "";
            }
                else{
                    //Calcuate Duration
                    $hours = intval(floor($diff / 3600)) . " hours";
                    $minutes = intval(floor((($diff % 3600)/60))) . " minutes";
                }
                
                $rentedfrom = $array['rented_from'];
                $returnedto = $array['returned_to'];
                $bikeid = $array['bikeid'];

                echo "<tr>
                        <td>".$rented."</td>
                        <td>".$returned."</td>
                        <td>".$hours." ".$minutes."</td>
                        <td>".$rentedfrom."</td>
                        <td>".$returnedto."</td>
                        <td>".$bikeid."</td>
                    </tr>";
            }
        echo"</tbody></table></div></div>";
        }


      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      if ($mysqli->errno) {
          print($mysqli->error);
          exit();
      }

      //select all of the albums grouped by aid
        //$result = $mysqli->query("SELECT * FROM Album");
        $useremail = $_SESSION['user'];
        $result = $mysqli->query("SELECT * FROM Rentals WHERE email = '$useremail' ");
        
        // Print out all the photos (use printPhotos)
        printMyTrips($result);

        // Closing connection
        $mysqli->close();
      ?>
