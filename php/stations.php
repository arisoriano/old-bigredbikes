<?php
$PAGE_TITLE='Stations';
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
    <script type="text/javascript" src="../javascript/stations.js"></script>
    
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
<body id='stations_0'>
    <?php
    include 'nav.php';
    if ($_SESSION['lvl'] == 'Manager' ){
            include 'admin_nav.php';
        }else{
            include 'checkout_nav.php'; 
        }
        
    ?>
    <div id='no_header_layout'>
    <div clasds="row" id="users">

    <?php
      function printStatus($result){                      
            while ( $array = $result->fetch_assoc() ) {

              $open = $array['open'];

             

              echo "  <td><select class='options' onchange='toggle_main(this)'>
                          <option value ='closed'>Closed</option>
                          <option value ='open'".($open?' selected':'').">Open</option>
                          </select>
                      </td>";
                }
      }

      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      if ($mysqli->errno) {
          print($mysqli->error);
          exit();
      }

      //select all of the albums grouped by aid
      //$result = $mysqli->query("SELECT * FROM Album");
      $result = $mysqli->query("SELECT * FROM Status");
      

      echo '<div class="row">
                <div class="col-lg-12">
                    <h1>&nbsp;&nbsp;Stations</h1>
                </div>
            </div>
            <div class="row">
                <div class="lefter">Operating Status:'; 
            printStatus($result);
              echo  '</div>   
                <img src="../images/search.png" alt="search"/>
                <div class="col-lg-4 col-lg-offset-1">
                               
                    <input type="search" id="search" value="" class="form-control" placeholder="Search for Stations"> 
                </div>
                <div class="righter"><button onclick="addStation()">Add Station</button></div>
            </div>

            <br/>
            
            <br />
            <div class="row">
                <div class="col-lg-12">
                    <table class="table" id="user_table">
                        <thead>
                          <tr>
                              <th>Name</th>
                              <th># Bikes</th>
                              <th># Helmets</th>
                              <th># Bikelocks</th>
                              <th>Status</th>
                              <th>&nbsp;</th>
                              <th>Options</td>
                          </tr>
                        </thead>
                        <tbody>';

      function printLog($result){
            global $mysqli;                        

            while ( $array = $result->fetch_assoc() ) {

              $name = $array['name'];
              $address = $array['address'];
              $num_helmets = $array['num_helmets'];
              $num_bikelocks = $array['num_bikelocks'];
              $flagged= $array['flagged'];
              $flagged_text= $array['flag_descript'];
              $hours= $array['hours_link'];
             
              $countRes= $mysqli->query("SELECT COUNT(*) FROM Bikes WHERE current_station='$name';");
              $countArr= $countRes->fetch_row();
              $num_bikes= $countArr[0];

              echo "<tr class='user_row'>
                      <td>".$name."</td>
                      <td>".$num_bikes."</td>
                      <td>".$num_helmets."</td>
                      <td>".$num_bikelocks."</td>
                      <td><select class='options' id='level_options' name='".$name."' onchange='set_status(this)'>
                          <option value ='open'>Open</option>
                          <option value ='closed'".($flagged?' selected':'').">Closed</option>
                          </select>
                      </td>
                      <td>".($flagged?"<img src='../images/flagged.png' class='rollover_alert' data-toggle='modal' onclick='flag(\"$name\", \"$flagged_text\")' data-target='#stationModal' />":"")."</td>
                      <td>
                        <button type='button' class='btn btn-default btn-sm' onclick='info(\"$name\",\"$address\",\"$num_bikes\",\"$num_helmets\",\"$num_bikelocks\", \"$hours\")'>Edit</button>
                        <button type='button' class='btn btn-default btn-sm' onclick='getNotes(\"$name\")'>Notes</button>
                        <button type='button' class='btn btn-default btn-sm' data-toggle='modal' data-target='#stationModal' onclick='deleteStation(\"$name\")'>Delete</button> 
                      </td>
                  </tr>";
                }
      echo"</tbody></table></div></div>";
      }

      //select all of the albums grouped by aid
      //$result = $mysqli->query("SELECT * FROM Album");
      $result = $mysqli->query("SELECT * FROM Stations");
      
      // Print out all the photos (use printPhotos)
      printLog($result);

      // Closing connection
      $mysqli->close();
    ?>


    </div><!--users-->   

    <!--Station Modal -->
    <div class="modal fade" id="stationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="stationTitle"></h4>
                </div>
                <div class="modal-body" id="stationBody">        
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeButton" class='btn btn-default btn' data-dismiss="modal"></button>
                    <button type="button" id="okButton" class='btn btn-default btn'></button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="add_station" tabindex="-1" role="dialog" aria-labelledby="add_station_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="bikeTitle">Add a Station</h4>
            </div>
            <div class="modal-body">
            <form action='add_station.php' method='post'> 
                <table>
                    <tr>
                        <td>Name:&nbsp;&nbsp;</td>
                        <td><input type='text' name='name' /></td>
                    </tr> 
                    <tr>
                        <td>Address:&nbsp;&nbsp;</td>
                        <td><input type='text' name='addr' /></td>
                    </tr> 
                    <tr>
                        <td>Hours Link:&nbsp;&nbsp;</td>
                        <td><input type='text' name='hours_link' /></td>
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

<div class="modal fade" id="edit_station" tabindex="-1" role="dialog" aria-labelledby="edit_station_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="stationTitle"></h4>
            </div>
            <div class="modal-body">
            <form action='edit_station_info.php' method='post'> 
                <table>
                    <tr>
                        <td>Address:&nbsp;&nbsp;</td>
                        <td><input type='text' name='addr2' /></td>
                    </tr> 
                    <tr>
                        <td>Hours Link:&nbsp;&nbsp;</td>
                        <td><input type='text' name='hours_link2' /></td>
                    </tr>
                    <tr>
                        <td># Bikes:&nbsp;&nbsp;</td>
                        <td><input type='text' name='bikes' style="width:50px"/></td>
                    </tr> 
                    <tr>
                        <td># Helmets:&nbsp;&nbsp;</td>
                        <td><input type='text' name='helmets' style="width:50px"/></td>
                    </tr>  
                    <tr>
                        <td># Bikelocks:&nbsp;&nbsp;</td>
                        <td><input type='text' name='locks' style="width:50px"/></td>
                    </tr>   
                </table>
                <input id="name_hidden" name="name" type="hidden" />
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
            <div class="modal-body">
            <form action='edit_station_note.php' method='post'> 
                Add a Note:<br /> 
                <textarea name='comment' rows='5' cols='50'></textarea>
                <input id="name_hidden2" name="name" type="hidden" />
            </div>
            <div class="modal-footer">
              <button type="button" class='btn btn-default btn' data-dismiss="modal">Cancel</button>
              <button type="submit" class='btn btn-default btn'>Submit</button></form>
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