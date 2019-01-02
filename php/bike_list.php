<?php
$PAGE_TITLE='List of Bikes';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; 
      if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }
 
    ?>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    
    <?php

        function debug( $data ) {

            if ( is_array( $data ) )
                $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
            else
                $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

            echo $output;
        }

    ?>
</head>
<body id='bikes_0'>
    <?php
    include 'nav.php';
    if ($_SESSION['lvl'] == 'Manager' ){
            include 'admin_nav.php';
        }else{
            include 'checkout_nav.php'; 
        }
        
    ?>
    <script type="text/javascript" src="../javascript/bikes.js"></script>
    <div id='no_header_layout'>
    <div class="row" id="bikes">

    <?php
      echo '<div class="row">
                <div class="col-lg-12">
                    <h1>&nbsp;&nbsp;Bikes</h1>
                </div>
            </div>
            <div class="row">   
                <img src="../images/search.png" alt="search"/>
                <div class="col-lg-4 col-lg-offset-4">
                               
                    <input type="search" id="search" value="" class="form-control" placeholder="Search for Bikes"> 
                </div>
                <div class="righter"><button onclick="addBike()">Add Bike</button></div>
            </div>

            <br/>
            
            <br />
            <div class="row">
                <div class="col-lg-12">
                    <table class="table" id="user_table">
                        <thead>
                          <tr>
                              <th>Bike ID</th>
                              <th>Date Added</th>
                              <th>Last Rented</th>
                              <th>Current Station</th>
                              <th>Status</th>
                              <th>&nbsp;</th>
                              <th>Options</td>
                          </tr>
                        </thead>
                        <tbody>';

      function printLog($result){                      
            while ( $array = $result->fetch_assoc() ) {

              $id = $array['bikeid'];
              $added = $array['date_added'];
              $last = $array['last_rented'];
              $current = $array['current_station'];
              $flagged= $array['flagged'];
              $flagged_text= $array['flag_descript'];
             

              echo "<tr class='user_row'>
                      <td>".$id."</td>
                      <td>".$added."</td>
                      <td>".($last==""?"Never":$last)."</td>
                      <td>".($current==""?"None":$current)."</td>
                      <td><select class='options' id='level_options' name='".$id."' onchange='set_flag(this)'>
                          <option value ='ok'>OK</option>
                          <option value ='flagged'".($flagged?' selected':'').">Flagged</option>
                          </select>
                      </td>
                      <td>".($flagged?"<img src='../images/flagged.png' class='rollover_alert' data-toggle='modal' onclick='flag(\"$id\", \"$flagged_text\")' data-target='#bikeModal' />":"")."</td>
                      <td>
                        <button type='button' class='btn btn-default btn-sm' onclick='info(\"$id\",\"$current\")'>Edit</button>
                        <button type='button' class='btn btn-default btn-sm' onclick='getNotes(\"$id\")'>Notes</button>
                        <button type='button' class='btn btn-default btn-sm' data-toggle='modal' data-target='#bikeModal' onclick='deleteBike(\"$id\")'>Delete</button>
                      </td>
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
      $result = $mysqli->query("SELECT * FROM Bikes");
      
      // Print out all the photos (use printPhotos)
      printLog($result);

      // Closing connection
      $mysqli->close();
    ?>


    </div><!--users-->   

    <!--Main Bike Modal -->
    <div class="modal fade" id="bikeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="bikeTitle"></h4>
                </div>
                <div class="modal-body" id="bikeBody">        
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeButton" class='btn btn-default btn' data-dismiss="modal"></button>
                    <button type="button" id="okButton" class='btn btn-default btn'></button>
                </div>
            </div>
        </div>
    </div>


      <div class="modal fade" id="add_bike" tabindex="-1" role="dialog" aria-labelledby="add_bike_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="bikeTitle">Add a Bike</h4>
            </div>
            <div class="modal-body">
            <form action='add_bike.php' method='post'> 
                <table>
                    <tr>
                        <td>Bike ID:&nbsp;&nbsp;</td>
                        <td><input type='text' name='bike_id' /></td>
                    </tr> 
                    <tr>
                        <td>Station: </td>
                        <td>
<?php
             function dropdown($name, $result){

              $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";

              while ($array = $result->fetch_assoc())
                {

                    /*** add each option to the dropdown ***/
                    $dropdown .= '<option value="'.$array['name'].'">'.$array['name'].'</option>'."\n";
                }

                /*** close the select ***/
                $dropdown .= '</select>'."\n";

                /*** and return the completed dropdown ***/
                return $dropdown;
            }

              $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

              if ($mysqli->errno) {
                  print($mysqli->error);
                  exit();
              }

              $result = $mysqli->query("SELECT * FROM Stations");

              echo dropdown('station', $result);
      ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class='btn btn-default btn' data-dismiss="modal">Cancel</button>
              <button type="submit" class='btn btn-default btn'>Add</button></form>
            </div>
          </div>
        </div>
      </div><!--Add Modal-->

      <div class="modal fade" id="edit_bike" tabindex="-1" role="dialog" aria-labelledby="edit_bike_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="bikeTitle"></h4>
            </div>
            <div class="modal-body">
            <form action='edit_bike_info.php' method='post'> 
                <table>
                    <tr>
                        <td>Current Station: </td>
                        <td>
<?php
             function dropdown3($name, $result){

              $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";
              $dropdown .= '<option id="initial" selected value=""></option>'."\n";

              while ($array = $result->fetch_assoc())
                {

                    /*** add each option to the dropdown ***/
                    $dropdown .= '<option value="'.$array['name'].'">'.$array['name'].'</option>'."\n";
                }

                /*** close the select ***/
                $dropdown .= '</select>'."\n";

                /*** and return the completed dropdown ***/
                return $dropdown;
            }

              $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

              if ($mysqli->errno) {
                  print($mysqli->error);
                  exit();
              }

              $result = $mysqli->query("SELECT * FROM Stations");

              echo dropdown3('station', $result);
      ?>
                        </td>
                    </tr>
                </table>
                <input id="bike_hidden_id2" name="bike_id" type="hidden" />
            </div>
            <div class="modal-footer">
              <button type="button" class='btn btn-default btn' data-dismiss="modal">Cancel</button>
              <button type="submit" class='btn btn-default btn'>Update</button></form>
            </div>
          </div>
        </div>
      </div><!--Edit Modal-->

      <div class="modal fade" id="edit_note" tabindex="-1" role="dialog" aria-labelledby="edit_note_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="noteTitle"></h4>
            </div>
            <div class="modal-body" id="noteBody"> 
                
            </div>
            <div class="modal-footer">
              <button type="button" class='btn btn-default btn' data-dismiss="modal">Cancel</button>
              <button type="submit" class='btn btn-default btn' id="noteOk">Add Note</button></form>
            </div>
          </div>
        </div>
      </div><!--Notes Modal-->

    </div><!--no_header_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>