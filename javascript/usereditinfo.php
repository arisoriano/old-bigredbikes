<?php
session_start();
$PAGE_TITLE='EditInfo';
?>

<!DOCTYPE html>
<head>
    <?php 
    
        $f= "";
        $l= "";
        $e= "";
        $a= "";
        $t= "";
        $fw= "";
        $lw= "";
        $ew= "";
        $pw= "";
        $aw= "";
        $tw= "";
        $cw="";
        $pwd= "";
        $allSet= TRUE;

        if (isset($_POST['firstname'])){
            $f = trim(strip_tags($_POST['firstname']));
            if(strlen($f)==0){
                $fw="Please enter a first name.";
                $allSet=FALSE;
            }
            //Characters and hyphens only
            elseif(!preg_match("/^([A-Za-z]+)(-*)(\s*)$/",$f)){
                $fw="First name can only contain letters, spaces, and hyphens.";
                $allSet=FALSE;
            }

        } 
        else{$allSet=FALSE;}


        //Check last name
        if (isset($_POST['lastname'])){
            $l = trim(strip_tags($_POST['lastname']));
            if(strlen($l)==0){
                $lw="Please enter a last name.";
                $allSet=FALSE;
            }
            //Characters and hyphens only
            elseif(!preg_match("/^([A-Za-z]+)(-*)(\s*)$/",$l)){
                $lw="Last name name can only contain letters, spaces, and hyphens.";
                $allSet=FALSE;
            }
        } 
        else{$allSet=FALSE;}

        //Check email
        if (isset($_POST['email'])){
            $e = trim(strip_tags($_POST['email']));
            if(strlen($e)==0){
                $ew="Please enter an email address.";
                $allSet=FALSE;
            }
            //Check if valid email
            elseif(filter_var($e, FILTER_VALIDATE_EMAIL)===FALSE){
                $ew="Email address is invalid.";
                $allSet=FALSE;
            }
            elseif(userExists($e)){
                $ew="There is already an acoount for this email.";
                $allSet=FALSE;
            }
        } 
        else{$allSet=FALSE;}

//         echo "ALL SET 4".($allSet?"TRUE":"FALSE");

        //Check passwords
        if (isset($_POST['pwd'])){
            $pwd = trim($_POST['pwd']);
            if(strlen($pwd)==0){
                $pw="Please enter a password.";
                $allSet=FALSE;
            }
            elseif(strlen($pwd)<6){
                $pw= "Password must be at least 6 characters.";
                $allSet=FALSE;
            }
            elseif(!isset($_POST['pwd2'])||strlen(trim($_POST['pwd2']))==0){
                $pw= "Please retype your password.";
                $allSet=FALSE;
            }
            else{
                $pwd2 = trim($_POST['pwd2']);
                if(strcmp($pwd,$pwd2)<>0){
                    $pw="Passwords do not match.";
                    $allSet=FALSE;
                }
            }

        } else{$allSet=FALSE;}

        

        //Check affiliation
        if (isset($_POST['affiliation'])){     
            $affils=array("Student","Staff/Faculty","Visitor");
            $a = trim(strip_tags($_POST['affiliation']));
            if(array_search($a,$affils)===FALSE){
                $allSet=FALSE;
                $aw="Not a valid affiliation.";
            }
        } else{$allSet=FALSE;}


        //Check phone number
        if (isset($_POST['phone'])){
            $t = trim(strip_tags($_POST['phone']));
            if(strlen($t)==0){
                $tw="Please enter a phone number.";
                $allSet=FALSE;
            }
            //Check for phone number characters
            elseif(!preg_match('/^([0-9]+)(-*)(\(*)(\)*)(\s*)$/',$t)){
                $tw="Please enter a valid phone number.";
                $allSet=FALSE;
            }
            
            //Must contain at least 7 digits
            elseif(strlen(preg_replace("/[^0-9]/", "", $t))<7){
                $tw="Please enter a valid phone number.";
                $allSet=FALSE;   
            }
        } else{$allSet=FALSE;}

        //Check that they've signed the waiver
        if(!isset($_POST['waiver'])){
            $cw="You must sign the waiver.";
            $allSet=FALSE;
        }

        //Checks if user is already in database
        function userExists($email){
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $query= "SELECT * FROM BikeshareUsers WHERE email=?";
            $stmt=$db->prepare($query);
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $result= $stmt->fetch();
            return($result!==FALSE);    
        }


        //Adds a user to the database
        function addUser(){
            global $e, $f, $l, $t, $a, $pwd;
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $time= date("Y-m-d H:i:s");
            $hashword= hash('sha256', $pwd.SALT);
            $query= "INSERT INTO BikeshareUsers (email, password, fname, lname, phone, affiliation, last_login) 
                     VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt= $db->prepare($query);
            $stmt->bindParam(1, $e);
            $stmt->bindParam(2, $hashword);
            $stmt->bindParam(3, $f);
            $stmt->bindParam(4, $l);
            $stmt->bindParam(5, $t);
            $stmt->bindParam(6, $a);
            $stmt->bindParam(7, $time);
            $stmt->execute();
            $result= $stmt->rowCount();
            //Set session variables
            if($result!=0){
                echo '<p>Thank you! Your registration is complete!<br />
                        <a href="login.php">Login Now</a>
                      </p>';
            }
            else{
                echo '<p>You have encountered an error. '.$db->errorInfo().'</p>';
            }
        }

        
        //Create the registration form
        function generateRegistration(){
            global $f,$l,$e,$a,$t,$fw,$lw,$ew,$pw,$aw,$tw,$cw;
            echo "<form action='register.php' method='post'> 
                <table>
                    <tr>
                        <td>First Name: </td>
                        <td><input type='text' value='$f' name='firstname' size='30' maxlength='30'/></td>
                        <td><span class='red'>* $fw</span></td>
                    </tr> 
                    <tr>
                        <td>Last Name: </td>
                        <td><input type='text' value='$l' name='lastname' size='30' maxlength='30'/></td>
                        <td><span class='red'>* $lw</span></td>
                    </tr>
                    <tr>
                        <td>Email: </td>
                        <td><input type='email' value='$e' name='email' size='30'/></td>
                        <td><span class='red'>* $ew</span></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type='password' name='pwd' size='30' maxlength='30'/></td>
                        <td><span class='red'>* $pw</span></td>
                    </tr>
                    <tr>
                        <td>Re-Enter<br/>Password: </td>
                        <td><input type='password' name='pwd2' size='30' maxlength='30'/></td>
                        <td><span class='red'>*</span></td>
                    </tr>
                    <tr>
                        <td>Affiliation: </td>
                        <td><select name='affiliation'>
                                <option".($a==''?"selected":"")." value=''>---- choose affiliation ----</option>
                                <option".($a=='Student'?"selected":"")." value='Student'>Student</option>
                                <option".($a=='Staff/Faculty'?"selected":"")." value='Staff/Faculty'>Staff/Faculty</option>
                                <option".($a=='Visitor'?"selected":"")." value='Visitor'>Visitor</option>
                            </select>
                        </td>
                        <td><span class='red'>*$aw</span></td>
                    </tr>
                    <tr>
                        <td>Phone: </td>
                        <td><input type='tel' value='$t' name='phone' size='30'/></td>
                        <td><span class='red'>* $tw</span></td>
                    </tr>
                </table>

                
                <p><input type='submit' name='submit' value='Register'/><input type='reset' value='Clear'/></p>
            </form>";
        }
    ?>
</head>
<body>

    <div id="register">
        <?php   
            global $allSet;
            
            if($allSet){
                addUser();
            }
            else{
                generateRegistration();
            }
            
        ?>

    </div>     
   
    </div><!--page_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>