      <?php
        if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
            header('Location: denied.php');
            die();
        }

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $admin_email=$_SESSION['user'];
        $res = $mysqli->query("SELECT * FROM BikeshareUsers WHERE email='$admin_email';");
        $row= $res->fetch_assoc();
        $admin=$row['fname'].' '.$row['lname'];


        function printUsers($result){
            echo '<div class="row">
                      <p>
                          <h1>&nbsp;&nbsp;&nbsp;Check Out / In Users</h1>
                      </p>
                  </div>
                  <div class="row">
                      <img src="../images/search.png" alt="search"/>
                      <div class="col-lg-4 col-lg-offset-4">
                          <input type="search" id="search" value="" class="form-control" placeholder="Search for Users">
                      </div>
                  </div>
                  <br/><br/>
                  <div class="row">
                      <div class="col-lg-12">
                          <table class="table" id="user_table">
                              <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Rental</th>
                                </tr>
                              </thead>
                              <tbody>';                      

             global $admin;
            $admin= "\"".$admin."\"";
              while ( $array = $result->fetch_assoc() ) {
  ;
          $name = $array['fname'].' '.$array['lname'];
          $email = $array['email'];
          $phone = $array['phone'];
          $status = $array['status'];
          $level = $array['permission_level'];
          $last_login = $array['last_login'];
          $rentalid = $array['rentalid'];

          
          $admin_email = $_SESSION['user'];

          $user = "\"".$name."\"";
          $user_email = "\"".$email."\"";

          $admin_email = "\"".$admin_email."\"";

          $rentalid2 = "\"".$rentalid."\"";
         
          echo "<tr class='user_row'>
                  <td>".$name."</td>
                  <td>".$email."</td>
                  <td style='display:none;''>
                  <td>";
                    if ($rentalid == NULL){
                      echo "
                            <button type='button' class='btn btn-default btn-sm' onclick='checkOut(".$user.",".$user_email.",".$admin.",".$admin_email.")'>Out</button>
                            <button type='button' disabled class='btn btn-default btn-sm' onclick='checkIn(".$user.",".$user_email.",".$admin.",".$admin_email.")'>In</button> 
                           ";
                    }else{
                      echo"
                          <button type='button' disabled class='btn btn-default btn-sm' onclick='checkOut(".$user.",".$user_email.",".$admin.",".$admin_email.")'>Out</button>
                          <button type='button' class='btn btn-default btn-sm' onclick='checkIn(".$user.",".$user_email.",".$admin.",".$admin_email.",".$rentalid2.")'>In</button> 
                          ";
                    }
     
                  "</td>
              </tr>";
            }
  echo"</tbody></table></div></div>";
  }

  

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }

  //select all of the albums grouped by aid
  //$result = $mysqli->query("SELECT * FROM Album");
  $result = $mysqli->query("SELECT * FROM BikeshareUsers");
  
  // Print out all the photos (use printPhotos)
  printUsers($result);

  // Closing connection
  $mysqli->close();
?>
