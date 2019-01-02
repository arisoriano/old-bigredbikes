<?php
$PAGE_TITLE='Reset Password';
?>
<!DOCTYPE html>
<head>
    <?php include 'head.php'; 

    //Reset the passwrd. Returns true if successful and false if it fails.
    function processReset($email, $newpassword){
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $query= "UPDATE BikeshareUsers SET password=? WHERE email=?;";
        $newpassword= hash('sha256', $newpassword.SALT);
        $stmt= $db->prepare($query);
        $stmt->bindParam(1, $newpassword);
        $stmt->bindParam(2, $email);
        $stmt->execute();
        return($stmt->rowCount());
    }

    function displayResetForm($warn, $email){
        echo "<p>$warn</p>
            <form method='POST' action='reset.php'>
                <table>
                <tr>
                    <td>New Password:</td><td><input type='password' name='pwd' /></td>
                </tr>
                <tr>
                    <td>Retype New Password:</td><td><input type='password' name='pwd2' /></td>
                </tr>
                </table>
                <input type='hidden' name='email' value='$email' />
                <p><input type='submit' value='Reset Password' /></p>    
            </form>";
     }

    //Attempta to reset password. Use if get parameters are set.
    function validResetLink($email, $token){
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $query= "SELECT * FROM BikeshareUsers WHERE token=? AND email=?";
        $stmt= $db->prepare($query);
        $stmt->bindParam(1, $token);
        $stmt->bindParam(2, $email);
        $stmt->execute();
        return($stmt->fetch()!==FALSE);
    }

    //Generate a link to allow a user to reset their password
    function generateLink($email){
        //Generate token to mark and validate reset later
        $salt= rand();
        $timestamp= time();
        $token= $timestamp.$salt;

        //Use prepared statement to insert token in to users table
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $query= "UPDATE BikeshareUsers SET token='$token' WHERE email=?;";
        $stmt= $db->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        //Did we find the email address?
        if($row= $stmt->rowCount()){
            $link_addr='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?email=$email&tok=$token";
            $message="Click the below link or paste it into your browser to reset your password.\r\n$link_addr";
            $sent= mail($email, "Big Red Bikes Password Reset", $message, 'From:bigredbikes@cornell.edu');
            //Check if email was successful.
            if($sent){
                echo '<p>A reset link has been sent to your email.</p>';
            }
            else{
                echo '<p>An error occurred. Please try again later.</p>';
            }
        }
        else{
            echo '<p>This email address was not found in our system. Register <a class="link_addr" href="register.php">here</a>.</p>.';
        }
    }

    //Display the blank email submission form
    function displayEmailForm($warn){
        echo '<p>To reset your password, enter the email address you registered with below. A reset link will
                  be emailed to your account.</p>
              <form method="POST" action="reset.php">
                <p><span class="red">'.$warn.'</span></p>
                <p>
                    Email: <input type="text" name="email" />
                    <input type="submit" value="Reset Password"/>
                </p>
              </form>';
    }

    ?>
</head>
<body id='how_0'>
    <?php include 'nav.php'; ?>
    <div id='photo'>
    </div><!--photo-->
    <div id='page_layout'>
        <h2>Reset your Password</h2>
        <?php 
            //Link for a reset form. Validate and display.
            if(isset($_GET['email'])&&isset($_GET['tok'])){
                $email= trim(strip_tags($_GET['email']));
                $tok= trim(strip_tags($_GET['tok']));
                if(validResetLink($email, $tok)){
                   displayResetForm("", $email);   
                }
                else{
                    displayEmailForm("Reset link is invalid. Please use the form below to reset your password.");
                }
                
            }
            //Submission for new password. Validate and attempt reset.
            elseif(isset($_POST['email'])&&isset($_POST['pwd'])&&isset($_POST['pwd2'])){
                $email= trim(strip_tags($_POST['email']));
                $pwd= trim(strip_tags($_POST['pwd']));
                $pwd2= trim(strip_tags($_POST['pwd2']));
                //Check email
                if(strlen($email)==0){
                   displayEmailForm("Please enter an email address.");
                }
                elseif(filter_var($email, FILTER_VALIDATE_EMAIL)===FALSE){
                   displayEmailForm("Please enter a valid email address."); 
                }
                else{
                    //Check passwords
                    if(strlen($pwd)==0){
                        displayResetForm("Please enter a new password.", $email);
                    }
                    elseif(strlen($pwd)<6){
                        displayResetForm("Password must be at least 6 characters.", $email);
                    }
                    elseif(strlen($pwd2)==0){
                        displayResetForm("Please retype your password.", $email);
                    }
                    elseif(strcmp($pwd,$pwd2)<>0){
                        displayResetForm("Passwords do not match.", $email);
                    }
                    //New passwords ok. Attempt to reset.
                    else{
                        $res= processReset($email,$pwd);
                        if($res){
                            echo '<p>Your password has been reset.</p>';
                        }
                        else{
                            echo '<p>Your password could not be reset.</p>';
                        }
                    }
                }
            

            }
            //Submission to recieve reset link. Validate and send email.
            elseif(isset($_POST['email'])){
                $email= trim(strip_tags($_POST['email']));
                if(strlen($email)==0){
                   displayEmailForm("Please enter an email address.");
                }
                elseif(filter_var($email, FILTER_VALIDATE_EMAIL)===FALSE){
                   displayEmailForm("Please enter a valid email address."); 
                }
                else{
                    generateLink($email);
                }
            }
            //Nothing set. Display form to acquire email.
            else{
                displayEmailForm("");
            }
        ?>

       
    </div>
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>