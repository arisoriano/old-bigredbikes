<?php
$PAGE_TITLE='My Account';
?>

<!DOCTYPE html>
<head>
    
    <?php include 'head.php'; 
      if(!isset($_SESSION['user'])){
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

<body <?php if ($_SESSION['lvl'] == 'Manager' ){echo "id='info_m0'";} if($_SESSION['lvl'] == 'Checkout' ){echo "id='info_c0'";} echo'>' ?>
    <?php include 'nav.php'; ?>
     
    <?php

    if ($_SESSION['lvl'] == 'Manager' ){
            include 'admin_nav.php';
        }
        if($_SESSION['lvl'] == 'Checkout' ){
            include 'checkout_nav.php'; 
        }

    $email = $_SESSION['user'];
    $email = "\"".$email."\"";

        
    ?>
    
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <div id='no_header_layout'>
    <div class="row" id="users">
        <?php 
        include 'hellouser.php'; 
        echo "<button type='button' data-toggle='modal' data-target='#edit_user' class='btn btn-default btn-sm'>Edit Profile</button>";
        
  echo '<div class="row">
            <div class="col-lg-12">
            
                <br/><h2>&nbsp;My Trips</h2>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <table class="table" id="user_table">
                    <thead>
                      <tr>
                          <th>Checkout Date/Time</th>
                          <th>Return Date/Time</th>
                          <th>Duration</th>
                          <th>Station Rented From</th>
                          <th>Station Returned To</th>
                          <th>Bike ID</th>
                      </tr>
                    </thead>
                    <tbody>';
    
            include 'mytrips.php'; 
    ?>
    </div><!--users-->
    </div><!--no_header_layout'-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->

      <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="edit_user_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h1 class="modal-title">Edit Profile</h1>
            </div>
            <div class="modal-body">
    <?php 
        
        

        $e= '';
        $a= '';
        $t= '';
        $ew= "";
        $pw= "";
        $aw= "";
        $tw= "";
        $pwd= "";
        $allSet= FALSE;

        function pop(){
            echo "<script> $('#edit_user').modal();</script>";
        }

        function load(){
            global $e, $a, $t;
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $initQuery= "SELECT * FROM BikeshareUsers WHERE email=?;";
            $initStmt= $db->prepare($initQuery);
            $initStmt->bindParam(1, $_SESSION['user']);
            $initStmt->execute();
            $row= $initStmt->fetch(PDO::FETCH_ASSOC);
        
            $e= $row['email'];
            $a= $row['affiliation'];
            $t= $row['phone'];
        }

        
        load();

        if(isset($_POST['Changes'])){
            $allSet=TRUE;
        }

        //Check email
        if (isset($_POST['email'])){
            $e = trim(strip_tags($_POST['email']));
            if(strlen($e)==0){
                $ew="Please enter an email address.";
                $allSet=FALSE;
                pop();
            }
            //Check if valid email
            elseif(filter_var($e, FILTER_VALIDATE_EMAIL)===FALSE){
                $ew="Email address is invalid.";
                $allSet=FALSE;
                pop();
            }
            elseif(strcmp($e,$_SESSION['user'])<>0 && userExists($e)){
                $ew="There is already an acount for this email.";
                $allSet=FALSE;
                pop();
            }
        } 
        
        //Check passwords
        if (isset($_POST['pwd'])&&strlen(trim($_POST['pwd']))<>0){
            $pwd = trim($_POST['pwd']);
            debug("PWD ".$pwd);
            if(strlen($pwd)<6){
                $pw= "Password must be at least 6 characters.";
                $allSet=FALSE;
                pop();
            }
            elseif(!isset($_POST['pwd2'])||strlen(trim($_POST['pwd2']))==0){
                $pw= "Please retype your password.";
                $allSet=FALSE;
                pop();
            }
            else{
                $pwd2 = trim($_POST['pwd2']);
                if(strcmp($pwd,$pwd2)<>0){
                    $pw="Passwords do not match.";
                    $allSet=FALSE;
                    pop();
                }
            }
        }


        //Check affiliation
        if (isset($_POST['affiliation'])){     
            $affils=array("Student","Staff/Faculty","Visitor");
            $a = trim(strip_tags($_POST['affiliation']));
            if(array_search($a,$affils)===FALSE){
                $allSet=FALSE;
                $aw="Not a valid affiliation.";
                pop();
            }
        }

        //Check phone number
        if (isset($_POST['phone'])){
            $t = trim(strip_tags($_POST['phone']));
            if(strlen($t)==0){
                $tw="Please enter a phone number.";
                $allSet=FALSE;
                pop();
            }
            //Check for phone number characters
            elseif(!preg_match('/^([0-9]+)(-*)(\(*)(\)*)(\s*)$/',$t)){
                $tw="Please enter a valid phone number.";
                $allSet=FALSE;
                pop();
            }
            
            //Must contain at least 7 digits
            elseif(strlen(preg_replace("/[^0-9]/", "", $t))<7){
                $tw="Please enter a valid phone number.";
                $allSet=FALSE;  
                pop(); 
            }
        }


        //Edits user in the database
        function changeUser(){
            global $e, $t, $a, $pwd, $allSet;
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $hashword= hash('sha256', $pwd.SALT);
            $allSet= FALSE;
            //NEED TO update only logged in users contact information
            $query= '';
            if(strlen($pwd)==0){
                $query= "UPDATE BikeshareUsers SET email=?, phone=?, affiliation=? WHERE email='".$_SESSION['user']."';";    
            }
            else{
                $query= "UPDATE BikeshareUsers SET email=?, phone=?, affiliation=?, password=? WHERE email='".$_SESSION['user']."';";
            }
           
            
            $stmt= $db->prepare($query);
            $stmt->bindParam(1, $e);
            $stmt->bindParam(2, $t);
            $stmt->bindParam(3, $a);
            if(strlen($pwd)<>0){
                $stmt->bindParam(4, $hashword);
            }
            $stmt->execute();
            $result= $stmt->rowCount();
            load();
            
            //Set session variables
            if($result!=0){  
                generateEdits();
                 
            }
            else{
                $err=$db->errorInfo();
                if($err[2]<>''){
                    echo '<p>You have encountered an error. '.$err[2].'</p>';
                    echo "<script> $('#edit_user').modal({show:true});</script>";
                    generateEdits();
                }
                $allSet=FALSE;
                generateEdits();
            }
            
  
        }

        
        //Create the make changes form
        function generateEdits(){
            global $e,$a,$t,$ew,$pw,$aw,$tw;
            echo "<form action='accountuser.php' method='post'> 
                <table style='border-collapse: separate; border-spacing: 0 .35em;'>
                    <tr>
                        <td>Email: </td>
                        <td><input type='email' value='$e' name='email' size='30'/></td>
                        <td><span class='red'> $ew</span></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type='password' name='pwd' size='30' maxlength='30'/></td>
                        <td><span class='red'> $pw</span></td>
                    </tr>
                    <tr>
                        <td>Re-Enter<br/>Password: </td>
                        <td><input type='password' name='pwd2' size='30' maxlength='30'/></td>
                        <td><span class='red'></span></td>
                    </tr>
                    <tr>
                        <td>Affiliation: </td>
                        <td><select name='affiliation'>
                                <option".($a==''?" selected":"")." value=''>---- choose affiliation ----</option>
                                <option".($a=='Student'?" selected":"")." value='Student'>Student</option>
                                <option".($a=='Staff/Faculty'?" selected":"")." value='Staff/Faculty'>Staff/Faculty</option>
                                <option".($a=='Visitor'?" selected":"")." value='Visitor'>Visitor</option>
                            </select>
                        </td>
                        <td><span class='red'>$aw</span></td>
                    </tr>
                    <tr>
                        <td>Phone: </td>
                        <td><input type='tel' value='$t' name='phone' size='30'/></td>
                        <td><span class='red'> $tw</span></td>
                    </tr>
                </table>
                <input id='user_hidden' name='user' type='hidden' />

                
                <p><input type='submit' name='Changes' value='Make Changes'/></p>
            </form>";
        }
    ?>

    <div id="register">
        <?php   
            if($allSet){
                changeUser();               
            }
            else{
                generateEdits();
            }
            
        ?>

    </div>   
            </div>
          </div>
        </div>
      </div><!--Check In Modal-->

</body>
</html>