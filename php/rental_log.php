<?php
$PAGE_TITLE='Rental Log';
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
<body id='rental_0'>
    <?php include 'nav.php';
    if ($_SESSION['lvl'] == 'Manager' ){
            include 'admin_nav.php';
        }else{
            include 'checkout_nav.php'; 
        }
    ?>
    <div id='no_header_layout'>
    <div class="row" id="users">

    <?php
      echo '<div class="row">
                <div class="col-lg-12">
                    <h1>&nbsp;&nbsp;Rental Log</hq>
                </div>
            </div>
            <div class="row">
            <img src="../images/search.png" alt="search"/>
                <div class="col-lg-4 col-lg-offset-4">
                <input type="search" id="search" value="" class="form-control" placeholder="Search for Rentals">
            </div>
            <p class="center">
              <td><br/>
              <span class="red">Select additional search filters below: </span><br/>
                <span>
                    <label> All </label>
                    <input type="radio" name="filter_rentals" class="filter_rentals" id="all" value="All">
                    <label>&nbsp;&nbsp;&nbsp;</label>
                </span>
                <span>
                    <label> Active </label>
                    <input type="radio" name="filter_rentals" class="filter_rentals" id="active" value="Active">
                    <label>&nbsp;&nbsp;&nbsp;</label>
                </span>
                <span>
                    <label> Returned </label>
                    <input type="radio" name="filter_rentals" class="filter_rentals" id="returned" value="Returned">
                    <label>&nbsp;&nbsp;&nbsp;</label>
                </span>
              </td>
            </p>
        </div>
        <br/>
        <br/>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table" id="user_table">
                        <thead>
                          <tr>
                              <th>Status</th>
                              <th>User</th>
                              <th>Bike</th>
                              <th>Checkout Time</th>
                              <th>Checkout Station</th>
                              <th>Checkout Admin</th>
                              <th>Checkin Time</th>
                              <th>Checkin Station</th>
                              <th>Checkin Admin</th>
                               
                          </tr>
                        </thead>
                        <tbody>';

      function printLog($result){                      
            while ( $array = $result->fetch_assoc() ) {

              $user= $array['email'];
              $checked_out = $array['time_rented'];
              $checked_in = $array['time_returned'];
              $station_out= $array['rented_from'];
              $station_in= $array['returned_to'];
              $admin_out=$array['checkout_admin'];
              $admin_in=$array['checkin_admin'];
              
              if($checked_in == NULL){
                $status = 'Active';
              }else{
                $status = 'Returned';
              }

              $bike = $array['bikeid'];

              echo "<tr class='rental_row'>
                      <td id='status'>".$status."</td>
                      <td>".$user."</td>
                      <td>".$bike."</td>
                      <td>".$checked_out."</td>
                      <td>".$station_out."</td>
                      <td>".$admin_out."</td>
                      <td>".$checked_in."</td>
                      <td>".$station_in."</td>
                      <td>".$admin_in."</td>
                      
                      
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
      $result = $mysqli->query("SELECT * FROM Rentals ORDER BY time_rented DESC;");
      
      // Print out
      printLog($result);

      // Closing connection
      $mysqli->close();
    ?>


    </div><!--users-->   

    </div><!--no_header_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>