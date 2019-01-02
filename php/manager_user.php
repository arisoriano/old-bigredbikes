<?php
  if(!isset($_SESSION['user'])||$_SESSION['lvl']=="None"){
        header('Location: denied.php');
        die();
  }

  $admin_email = $_SESSION['user'];

  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($mysqli->errno) {
      print($mysqli->error);
      exit();
  }
  
  $res = $mysqli->query("SELECT * FROM BikeshareUsers WHERE email='$admin_email';");
  $row= $res->fetch_assoc();
  $admin=$row['fname'].' '.$row['lname'];

  function getName($result){
    while ( $array = $result->fetch_assoc() ) {
      $name = $array['fname'].' '.$array['lname'];
    }
    return $name;
  }

  echo '<div class="row">
            <div class="col-lg-12">
                <h1>&nbsp;&nbsp;User Database</h1>
            </div>
        </div>
        <div class="row">
        <img src="../images/search.png" alt="search"/>
            <div class="col-lg-4 col-lg-offset-4">
                <input type="search" id="search" value="" class="form-control" placeholder="Search for Users">
            </div>
            <p class="center">
              <td><br/>
              <span class="red">Select additional search filters below: </span><br/>
                <span>
                    <label> Active </label>
                    <input type="checkbox" class="filter_user" id="active" value="Active">
                    <label>&nbsp;&nbsp;&nbsp;</label>
                </span>
                <span>
                    <label> Pending </label>
                    <input type="checkbox" class="filter_user" id="pending" value="Pending">
                    <label>&nbsp;&nbsp;&nbsp;</label>
                </span>
                <span>
                    <label> Disabled </label>
                    <input type="checkbox" class="filter_user" id="disabled" value="Disabled">
                    <label>&nbsp;&nbsp;&nbsp;</label>
                </span>
                <span>
                    <label> Checkout </label>
                    <input type="checkbox" class="filter_user" id="checkout" value="Checkout">
                    <label>&nbsp;&nbsp;&nbsp;</label>
                </span>
                <span>
                    <label> Manager </label>
                    <input type="checkbox" class="filter_user" id="manager" value="Manager">
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
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Admin Level</th>
                          <th>Status</th>
                          <th>Rental</th>
                      </tr>
                    </thead>
                    <tbody>';

  function printUsers($result){                      
        global $admin;
        $admin = "\"".$admin."\"";
        while ( $array = $result->fetch_assoc() ) {

          $name = $array['fname'].' '.$array['lname'];
          $email = $array['email'];
          $phone = $array['phone'];
          $status = $array['status'];
          $level = $array['permission_level'];
          $last_login = $array['last_login'];
          $rentalid = $array['rentalid'];

          
          $admin_email= $_SESSION['user'];

          $user = "\"".$name."\"";
          $user_email = "\"".$email."\"";

          
          $admin_email = "\"".$admin_email."\"";
          $rentalid2 = "\"".$rentalid."\"";

          echo "<tr class='user_row'>
                  <td>".$name."</td>
                  <td>".$email."</td>
                  <td>".$phone."</td>
                  <td style='display:none;'>
                  <td><select class='options' id='level_options' name='".$email."' onchange='toggle(this)'>
                          <option id='initial' selected value='".$level."' disabled>".$level."</option>
                          <option value ='None'>None</option>
                          <option value ='Checkout'>Checkout</option>
                          <option value ='Manager'>Manager</option>
                  </select></td>
                  <td><select class='options' id='status_options' name='".$email."' onchange='toggle(this)'>
                          <option id='initial' selected value='".$status."' disabled>".$status."</option>
                          <option value ='Active'>Active</option>
                          <option value ='Disabled'>Disabled</option>
                          <option value ='Pending'>Pending</option>
                  </select></td>
                  <td>";
                    if ($rentalid == NULL){
                      echo "
                            <button type='button' class='btn btn-default btn-sm' onclick='checkOut(".$user.",".$user_email.",".$admin.",".$admin_email.")'>Out</button>
                            <button type='button' disabled class='btn btn-default btn-sm''>In</button> 
                           ";
                    }else{
                      echo"
                          <button type='button' disabled class='btn btn-default btn-sm'>Out</button>
                          <button type='button' class='btn btn-default btn-sm' onclick='checkIn(".$user.",".$user_email.",".$admin.",".$admin_email.",".$rentalid2.")'>In</button> 
                          ";
                    }
     
                  "</td>
              </tr>";
            }
  echo"</tbody></table></div></div>";
  }



  //select all of the albums grouped by aid
  //$result = $mysqli->query("SELECT * FROM Album");
  $result = $mysqli->query("SELECT * FROM BikeshareUsers");
  
  // Print out all the photos (use printPhotos)
  printUsers($result);

  // Closing connection
  $mysqli->close();
?>
