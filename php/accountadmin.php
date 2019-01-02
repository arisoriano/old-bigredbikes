<?php
$PAGE_TITLE='Admin';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; 
      if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
    }
    ?>
    
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
<body <?php if ($_SESSION['lvl'] == 'Manager' ){echo "id='users_0'";} else{echo "id='checkout_0'";}?>>
    <?php include 'nav.php';
    if ($_SESSION['lvl'] == 'Manager' ){
            include 'admin_nav.php';
        }else{
            include 'checkout_nav.php'; 
        }
    ?>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <div id='no_header_layout'>
    <div class="row" id="users">
        <?php 


        if ($_SESSION['lvl'] == 'Manager' ){
            include 'manager_user.php';
        }else{
            include 'checkout_user.php'; 
        }

        

        ?>
    </div><!--users-->   

      <div class="modal fade" id="check_out" tabindex="-1" role="dialog" aria-labelledby="checkout_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h1 class="modal-title">Check Out</h1>
            </div>
            <div class="modal-body">
            <form action='checkout.php' method='post'> 
                <table>
                    <tr>
                        <td>User: </td>
                        <td><p id='user_info'></td>
                    </tr> 
                    <tr>
                        <td>Admin: </td>
                        <td><p id='admin_info'></td>
                    </tr>
                    <tr>
                        <td>Station: </td>
                        <td>
<?php
             function dropdown($name, $result){

              $dropdown = '<select name="'.$name.'" id="'.$name.'" onchange="getBikes()">'."\n";
              $dropdown .= '<option value="">None</option>'."\n";

              while ( $array = $result->fetch_assoc() )
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
                    <tr>
                        <td>Bike: </td>
                        <td id="bike_list">Select a station.
                            
                        <?php
                        /*function dropdown2($name, $result){

                            $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";
                            $dropdown .= '<option value="">--</option>'."\n";

                            while ( $array = $result->fetch_assoc() )
                            {

                                //add each option to the dropdown
                                $dropdown .= '<option value="'.$array['bikeid'].'" class="bike_option" id="'.$array['current_station'].'">'.$array['bikeid'].'</option>'."\n";
                            }

                            //close the select
                            $dropdown .= '</select>'."\n";

                            //and return the completed dropdown
                            return $dropdown;
                        }


                        $result = $mysqli->query("SELECT * FROM Bikes");
    
                        echo dropdown2('bike', $result);

                       // Closing connection
                       $mysqli->close();*/

                      ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Date: </td>
                        <td><?php echo date("m-d-Y h:i:sa") ?></td>
                    </tr>
                </table>
                <input id="user_hidden" name="user_out" type="hidden" />
                <input id="admin_hidden" name="admin_out" type="hidden" />
            </div>
            <div class="modal-footer">
              <button type="button" class='btn btn-default btn' data-dismiss="modal">Close</button>
              <button type="submit" class='btn btn-default btn'>Check Out</button></form>
            </div>
          </div>
        </div>
      </div><!--Check Out Modal-->


      <div class="modal fade" id="check_in" tabindex="-1" role="dialog" aria-labelledby="checkin_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h1 class="modal-title">Check In</h1>
            </div>
            <div class="modal-body">
            <form action='checkin.php' method='post'> 
                <table>
                    <tr>
                        <td>User: </td>
                        <td><p id='user_info_in'></td>
                    </tr> 
                    <tr>
                        <td>Admin: </td>
                        <td><p id='admin_info_in'></td>
                    </tr>
                    <tr>
                        <td>Station: </td>
                        <td>
<?php
             function dropdown3($name, $result){

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

              echo dropdown3('station', $result);
      ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Bike: </td>
                        <td><p id='bike_in'></td>
                    </tr>
                    <tr>
                        <td>Checked Out By: </td>
                        <td><p id='admin_out'></td>
                    </tr>
                    <tr>
                        <td>Checked Out Station: </td>
                        <td><p id='station_out'></td>
                    </tr>
                    <tr>
                        <td>Check Out Date: </td>
                        <td><p id='date_out'></td>
                    </tr>
                    <tr>
                        <td>Check In Date: </td>
                        <td><?php echo date("m-d-Y h:i:sa") ?></td>
                    </tr>
                    <tr>
                        <td>Late: </td>
                        <td><select id='status_options' name='late_options'>
                                <option selected value='NO'>NO</option>
                                <option value ='YES'>YES</option>
                        </select></td>
                    </tr>
                </table>
                <input id="user_hidden_in" name="user_in" type="hidden" />
                <input id="admin_hidden_in" name="admin_in" type="hidden" />
                <input id="rentalid_hidden" name="rental_id" type="hidden" />
            </div>
            <div class="modal-footer">
              <button type="button" class='btn btn-default btn'data-dismiss="modal">Close</button>
              <button type="submit" class='btn btn-default btn'>Check In</button></form>
            </div>
          </div>
        </div>
      </div><!--Check In Modal-->

    </div><!--no_header_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>