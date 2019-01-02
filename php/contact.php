<?php
$PAGE_TITLE='Contact';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; ?>
    <script src="../javascript/jquery-1.7.2.js" type='text/javascript'></script>
    <script src="../javascript/jquery.maskedinput-1.3.min.js" type='text/javascript'></script>
</head>
<body>
    <div id='header_contact'>
        <?php include 'nav.php'; ?>
        <?php
            $ferror='';
            $lerror='';
            $eerror='';
            $merror='';
            $rerror='';
            $oerror='';

            $firstname = "";
            $lastname = "";
            $e_mail = "";
            $message = "";
            $reason = "";
            $phone = "";
            $org = "";
            
            $allSet=TRUE;
            
            //Check first name
            if (isset($_POST['firstname'])){
                $firstname = trim(strip_tags($_POST['firstname']));
                if(strlen($firstname)==0){
                    $ferror="Please enter a first name.";
                    $allSet=FALSE;
                }
                
                //Characters and hyphens only
                elseif(!preg_match("/^([A-Za-z]+)(-*)(\s*)$/",$firstname)){
                    $ferror="First name can only contain letters, spaces, and hyphens.";
                    $allSet=FALSE;
                }
            } else {
                $allSet=FALSE;
            }

            //Check last name
            if (isset($_POST['lastname'])){
                $lastname = trim(strip_tags($_POST['lastname']));
                if(strlen($lastname)==0){
                    $lerror="Please enter a last name.";
                    $allSet=FALSE;
                }
                
                //Characters and hyphens only
                elseif(!preg_match("/^([A-Za-z]+)(-*)(\s*)$/",$lastname)){
                    $lerror="Last name can only contain letters, spaces, and hyphens.";
                    $allSet=FALSE;
                }
            } else {
                $allSet=FALSE;
            }

            //Check email
            if (isset($_POST['email'])){
                $e_mail = trim(strip_tags($_POST['email']));
                if(strlen($e_mail)==0){
                    $eerror="Please enter an email address.";
                    $allSet=FALSE;
                }
                //Check if valid email
                elseif(filter_var($e_mail, FILTER_VALIDATE_EMAIL)===FALSE){
                    $eerror="Email address is invalid.";
                    $allSet=FALSE;
                }
            } else{
                $allSet=FALSE;
            }

            //Check phone number
            if (isset($_POST['phone'])){
                $phone = trim(strip_tags($_POST['phone']));
            } else {
                $allSet=FALSE;
            }

            if (isset($_POST['org'])){
                $org = trim(strip_tags($_POST['org']));
            } else{
                $allSet=FALSE;
            }

            if (isset($_POST['message'])){
                $message = trim(strip_tags($_POST['message']));
                if(strlen($message)==0){
                    $merror='Please enter a message.';
                }
            } else {
                $allSet=FALSE;
            }
            
            if (isset($_POST['reason'])){
                $reason = trim(strip_tags($_POST['reason']));
                if(strlen($reason)==0){
                    $rerror='Please choose a reason from the menu';
                }
            } else{
                $allSet=FALSE;
            }
            
            
            
            function mailContact(){
                global $f,$l,$e,$m,$r,$p,$o,$ferror,$lerror,$eerror,$merror,$rerror,$perror,$oerror,$firstname,$lastname,$e_mail,$message,$reason,$phone,$org;
                if (isset($_POST['submit'])){
                    //email contact form
                    $to = "aas257@cornell.edu";
                    $subject = "BRB Contact Form: $reason";
                    
                    $email_body = "You have received a new message from the Big Red Bikes Contact Form.".
                    "\n\n Reason for Contact: $reason".
                    "\n\n Message:" . 
                    "\n $message" .
                    "\n\n Contact Information to Respond" .
                    "\n---------------------------------------" .
                    "\n Name: $firstname $lastname".
                    "\n Email: $e_mail".
                    "\n Phone: $phone".
                    "\n Organization/Department: $org" .
                    "\n---------------------------------------";
                    
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= "From: $firstname $lastname <$e_mail>\r\n"; 
                    $headers .= "Reply-To: $e_mail\r\n";
                    
                    $headers_brb  = 'MIME-Version: 1.0' . "\r\n";
                    $headers_brb .= "From: 'Big Red Bikes' <no-reply@bigredbikes.com>\r\n"; 
            
                    mail($to, $subject, $email_body,$headers);
                    //Send confirmation to user
                    mail($e_mail, "Big Red Bikes Contact Form Confirmation", "Thank you for your message, we will get back to you soon.\n\nDO NOT REPLY to this message.",$headers_brb);   
        
                   header("Location: thankyou_home.php");
                   exit;
                }
            }
            
           
           

       ?>
    </div><!--header-->
    <div id='photo' class='fade_full0'>
        <img src='../images/contact.png' class='banner_pic' alt='contact'>
    </div><!--photo-->
    <div id='page_layout' class='fade_full1'>
        <?php
        
        function genContact(){
            global $f,$l,$e,$m,$r,$p,$o,$ferror,$lerror,$eerror,$merror,$rerror,$perror,$oerror,$firstname,$lastname,$e_mail,$message,$reason,$phone,$org;
            
        echo
        "Enter your contact information and message in the areas provided below.<br />
        We will get back to you as soon as we can.<br/>          
        <div id='contact'>
            <p></p>
        <form action='contact.php' method='post'>
            <table>
            <tr>
                <td>First Name: </td>
                <td><input type='text' name='firstname' size='30' maxlength='30' value='$firstname'/>&nbsp;<span class='red'>* $ferror</span></td>
            </tr>
            <tr>
                <td>Last Name: </td>
                <td><input type='text' name='lastname' size='30' maxlength='30' value='$lastname'/>&nbsp;<span class='red'>* $lerror</span></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><input type='email' name='email' size='30'/>&nbsp;<span class='red'>* $eerror</span></td>
            </tr>
            <tr>
                <td>Phone: </td>
                <td><input type='text' id='phone' name='phone' size='30' maxlength='20' value='$phone'/><script src='../javascript/phone.js' type='text/javascript'></script></td>
            </tr>
            <tr>
                <td>Organization/<br/>Department: </td>
                <td><input type='text' name='org' size='30' maxlength='40'/></td>
            </tr>
            <tr>
                <td>Reason for<br/>Contact: </td>
                <td>
                    <select name='reason'>
                        <option selected value=''>- choose reason for contact -</option>
                        <option value='Donation'>Donation Request</option>
                        <option value='More Information'>Information Request</option>
                        <option value='General Comments'>General Comments &amp; Feedback</option>
                        <option value='Other'>Other (not specified)</option>
                    </select>&nbsp;<span class='red'>* <br/>$rerror</span>
                </td>
            </tr>
            <tr>
                <td>Message: </td>
                <td>
                <textarea name='message' rows='10' cols='50'>$message</textarea>&nbsp;<span class='red'>* <br/>$merror</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type='submit' name='submit' value='Send Message'/><input type='reset' value='Clear'/></td>
            </tr>
            </table> 
        </form>";
        }
        ?>
         
         <?php   
            global $allSet;
            
            if($allSet){
                mailContact();
            }
            else{
                genContact();
            }
            
        ?>
  
        </div><!--contact-->
        
    </div><!--page_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>