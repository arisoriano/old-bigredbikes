<?php
$PAGE_TITLE='Bike Log';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; ?>
    
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
<body>
    <?php include 'nav.php'; ?>
    <?php include 'admin_nav.php'; ?>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <div id='no_header_layout'>
    <div class="row" id="users">

    <?php
      echo '<div class="row">
                <div class="col-lg-12">
                    <h2>Users</h2>
                </div>
            </div>
            <div class="row">
            <img src="../images/search.png" alt="search"/>
                <div class="col-lg-4 col-lg-offset-4">
                    <input type="search" id="search" value="" class="form-control" placeholder="Search">
            </div>
            <br/>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table" id="user_table">
                        <thead>
                          <tr>
                              <th>Name</th>
                              <th>Bikes Available</th>
                          </tr>
                        </thead>
                        <tbody>';

      function printLog($result){                      
            while ( $array = $result->fetch_assoc() ) {

              $name = $array['name'];
              $address = $array['address'];
              $num_bikes = $array['num_bikes'];
              $num_helmets = $array['num_helmets'];
              $num_bikelocks = $array['num_bikelocks'];

              // $admin = 'Claire Blumenthal';
              // $admin_email = 'admin@admin.com';

              // $user = "\"".$name."\"";
              // $user_email = "\"".$email."\"";

              // $admin = "\"".$admin."\"";
              // $admin_email = "\"".$admin_email."\"";
             

              echo "<tr class='user_row'>
                      <td>".$name."</td>
                      <td>".$num_bikes."</td>
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
      $result = $mysqli->query("SELECT * FROM Stations");
      
      // Print out all the photos (use printPhotos)
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