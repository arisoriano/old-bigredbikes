<?php
$PAGE_TITLE='Recruitment';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; ?>
    <script src="../javascript/jquery-1.7.2.js" type='text/javascript'></script>
    <script src="../javascript/jquery.maskedinput-1.3.min.js" type='text/javascript'></script>
    <?php


        function debug( $data ) {

            if ( is_array( $data ) )
                $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
            else
                $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

            echo $output;
        }

        //$mysqli = new mysqli('localhost', $login, $password, $databaseName);  


        //Add application to application list in database


    ?>
</head>
<body id='apply_0'>
    <?php include 'nav.php'; ?>
    <?php include 'recruitment_nav.php'; ?>
    <div id='photo' class='fade_full0'>
        <img class='banner_pic' src='../images/apply.png' alt='apply'>
    </div><!--photo-->
    <div id='page_layout' class='fade_full1'>
        We have an open and competitive recruitment process in which we welcome 
        students to join our Business, Marketing & Media, Operations, and 
        Research & Development teams regardless of major or class. 
        At Big Red Bikes we look for creativity, independence, 
        self-motivation and collaboration. While experience is greatly 
        valued, we recruit assuming that people of any level learn best by doing.
        <br/>
        <p>To apply to Big Red Bikes, please fill out the required fields below and submit your resume at the end.</p>
        <p>Please direct any questions to <a class='page_links' href="mailto:bigredbikesrecruitment@gmail.com">bigredbikesrecruitment@gmail.com</a></p>
        <br/>

         <?php
         
            $ferror='';
            $lerror='';
            $eerror='';
            $perror='';
            $cerror='';
            $merror='';
            $whaterror='';
            $whyerror='';
            $areerror='';
            $woulderror='';

            $firstname = "";
            $lastname = "";
            $e_mail = "";
            $phone = "";
            $college = "";
            $major = "";
            $status = "";
            $teams = "";
            $what_experiences = "";
            $why_interested = "";
            $are_you_interested = "";
            $what_would_you = "";
            $hours='';
            $days_avail = "";

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
                if(strlen($phone)==0){
                    $perror="Please enter a phone number.";
                    $allSet=FALSE;
                }
                
            } else{
                $allSet=FALSE;
            }

            //Check college
            if (isset($_POST['college'])){
                $college = trim(strip_tags($_POST['college']));
                if(strlen($college)==0){
                    $cerror="Please enter a college at Cornell.";
                    $allSet=FALSE;
                }
                
                //Characters and hyphens only
                elseif(!preg_match("/^[a-zA-Z\s]*$/",$college)){
                    $cerror="College can only contain letters and spaces.";
                    $allSet=FALSE;
                }
            } else {
                $allSet=FALSE;
            }

            
            //Check major
            if (isset($_POST['major'])){
                $major = trim(strip_tags($_POST['major']));
                if(strlen($major)==0){
                    $merror="Please enter a major at Cornell.";
                    $allSet=FALSE;
                }
                
                //Characters and hyphens only
                elseif(!preg_match("/^[a-zA-Z\s]*$/",$major)){
                    $merror="Major can only contain letters and spaces.";
                    $allSet=FALSE;
                }
            } else {
                $allSet=FALSE;
            }
            
        
            //Get student status
            if (isset($_POST['status']) && isset($_POST['submit'])){
                $status = strip_tags($_POST['status']);
            } 

            //Get teams
            if (isset($_POST['teams'])){
                $teams = strip_tags($_POST['teams']);
            } 

            //Check what experiences question
            if (isset($_POST['what_experiences'])){
                $what_experiences = trim(strip_tags($_POST['what_experiences']));
                if(strlen($what_experiences)==0){
                    $whaterror='Please fill out field';
                }
            } else {
                $allSet=FALSE;
            }

            //Check why interested question
            if (isset($_POST['why_interested'])){
                $why_interested = trim(strip_tags($_POST['why_interested']));
                if(strlen($why_interested)==0){
                    $whyerror='Please fill out field';
                }
            } else {
                $allSet=FALSE;
            }
            
            //Check are you interested questions
            if (isset($_POST['are_you_interested'])){
                $are_you_interested = trim(strip_tags($_POST['are_you_interested']));
                if(strlen($are_you_interested)==0){
                    $areerror='Please fill out field';
                }
            } else {
                $allSet=FALSE;
            }
               
            //Check what would you question
            if (isset($_POST['what_would_you'])){
                $what_would_you = trim(strip_tags($_POST['what_would_you']));
                if(strlen($what_would_you)==0){
                    $woulderror='Please fill out field';
                }
            } else {
                $allSet=FALSE;
            }
            
            
            //Get hours
            if (isset($_POST['hours'])){
                $hours = strip_tags($_POST['hours']);
            } 
            
            //Get days available
            if (isset($_POST['days_avail'])){
                $days_avail = strip_tags($_POST['days_avail']);
            } 

            
            // Send out application 
            function mailApply(){
                global $ferror,$lerror,$eerror,$perror,$cerror,$merror,$whaterror,$whyerror,$areerror,$woulderror,$firstname,$lastname,$e_mail,$phone,$college,$major,$status,$teams,$what_experiences,$why_interested,$are_you_interested,$what_would_you,$hours,$days_avail;
                if (isset($_POST['submit'])){
                    //email contact form
                    $to = "aas257@cornell.edu";
                    $subject = "BRB Application: $firstname $lastname";

                    $message = "You have received a new application.\n\n".
                    $message=
                    "Candidate Information".
                    "\n-----------------------------------------------------" .
                    "\n Name: $firstname $lastname" .
                    "\n E-Mail: $e_mail" .
                    "\n Phone: $phone" .
                    "\n College: $college" .
                    "\n Major: $major" .
                    "\n Status: $status" .
                    "\n-----------------------------------------------------" .
                    "\n\nApplication".
                    "\n-----------------------------------------------------" .
                    "\n What team(s) are you interested in joining?: $teams" .
                    "\n\n What experiences, skills, or qualities will you bring to Big Red Bikes?:" ."
                    \n $what_experiences" .
                    "\n\n Why are you interested in joining Big Red Bikes?:" .
                    "\n $why_interested" .
                    "\n\n Are you interested in any particular project(s) Big Red Bikes has planned?" .
                    "Are there any projects you would like to initiate as part of BRB?:" .
                    "\n $are_you_interested" .
                    "\n\n What would you do if you got behind schedule with your part of a project?:" .
                    "\n $what_would_you" .
                    "\n\n How many hours per week are you available to work per week?: $hours" .
                    "\n\n What days are you available: $days_avail".
                    "\n-----------------------------------------------------";
                
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= "From: $firstname $lastname <$e_mail>\r\n"; 
                    $headers .= "Reply-To: $e_mail\r\n";
                    
                    $headers_brb  = 'MIME-Version: 1.0' . "\r\n";
                    $headers_brb .= "From: 'Big Red Bikes' <no-reply@bigredbikes.com>\r\n"; 
                    
                    mail($to, $subject, $message, $headers);
                    //Send confirmation to user
                    mail($e_mail, "Big Red Bikes Application Confirmation", "Thank you for your application, we will get back to you soon.\n\nDO NOT REPLY to this message.",$headers_brb);  
    
                    header("Location: thankyou_home.php");
                    exit;
                    }
                }
        
        ?>
        <?php
        
        function genApply(){
            global $ferror,$lerror,$eerror,$perror,$cerror,$merror,$whaterror,$whyerror,$areerror,$woulderror,$firstname,$lastname,$e_mail,$phone,$college,$major,$status,$teams,$what_experiences,$why_interested,$are_you_interested,$what_would_you,$hours,$days_avail;
            
            echo "<form action='apply.php' method='post'>
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
                        <td><input type='email' name='email' size='30' value='$e_mail'/>&nbsp;<span class='red'>* $eerror</span></td>
                    </tr>
                    <tr>
                        <td>Phone: </td>
                        <td><input id='phone' type='text' name='phone' size='30' maxlength='30' value='$phone' />
                        <script src='../javascript/phone.js' type='text/javascript'></script>&nbsp;<span class='red'>* $perror</span></td>
                    </tr>
                    <tr>
                        <td>College: </td>
                        <td><input type='text' name='college' size='30' maxlength='30' value='$college'/>&nbsp;<span class='red'>* $cerror</span></td>
                    </tr>
                    <tr>
                        <td>Major: </td>
                        <td><input type='text' name='major' size='30' maxlength='30' value='$major'/>&nbsp;<span class='red'>* $merror</span></td>
                    </tr>
                    <tr>
                        <td>Status: </td>
                        <td>
                            <input type='radio' name='status' value='Undergraduate'/>
                            <label> Undergraduate </label>
                            <input type='radio' name='status' value='Graduate'/>
                            <label> Graduate </label>
                        </td>
                    </tr>
                </table>
                <br/>
                <table>
                    <tr>
                        <td>What team(s) are you interested in joining?&nbsp;<br/><br/></td>
                        <td>
                            <input type='checkbox' name='teams' value='Business'/>
                            <label> Business </label><br/>
                            <input type='checkbox' name='teams' value='Marketing & Media'/>
                            <label> Marketing & Media </label><br/>
                            <input type='checkbox' name='teams' value='Operations'/>
                            <label> Operations </label><br/>
                            <input type='checkbox' name='teams' value='Research & Development'/>
                            <label> Research & Development </label><br/>
                            <input type='checkbox' name='teams' value='Admin/Human Resources'/>
                            <label> Admin/Human Resources </label> 
                        </td>
                    </tr>
                    <tr>
                        <td>What experiences, skills or qualities will you bring to Big Red Bikes?&nbsp;<span class='red'>* $whaterror</span></td>
                        <td>
                        <br><textarea name='what_experiences' rows='10' cols='50' maxlength='750'>$what_experiences</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Why are you interested in joining Big Red Bikes?&nbsp;<span class='red'>* $whyerror</span></td>
                        <td>
                        <br><textarea name='why_interested' rows='10' cols='50' maxlength='750'>$why_interested</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td> Are you interested in any particular project(s) Big Red Bikes has planned? Are there any projects you would like to initiate as part
                        of BRB?&nbsp;<span class='red'>* $areerror</span></td>
                        <td>
                        <br><textarea name='are_you_interested' rows='10' cols='50' maxlength='750'>$are_you_interested</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td> What would you do if you got behind schedule with your part of a project?&nbsp;<span class='red'>* $woulderror</span></td>
                        <td>
                        <br><textarea name='what_would_you' rows='10' cols='50' maxlength='750'>$what_would_you</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>How many hours per week are you able to work per week?&nbsp;</td>
                        <td>
                            <span>
                                <input type='radio' name='hours' value='1-3'/>
                                <label> 1-3 hours </label>
                            </span>
                            <span>
                                <input type='radio' name='hours' value='3-6'/>
                                <label> 3-6 hours </label>
                            </span>
                            <span>
                                <input type='radio' name='hours' value='6+'/>
                                <label> 6+ hours </label>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Select the days for which you are available:&nbsp;</td>
                        <td><br>
                            <span>
                                <input type='checkbox' name='days_avail' value='Tuesday'/>
                                <label> Tuesday 4:30pm-7:00pm </label>
                            </span><br>
                            <span>
                                <input type='checkbox' name='days_avail' value='Wednesday'/>
                                <label> Wednesday 4:30pm-7:00pm </label>
                            </span><br>
                            <span>
                                <input type='checkbox' name='days_avail' value='Thursday'/>
                                <label> Thursday 4:30pm-7:00pm</label>
                                <br/><br/>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td></td><td><input type='submit' name='submit' value='Submit Application'/><input type='reset' value='Clear'/></td>
                    </tr>
                </table>
            </form>";
        }
        ?>
        
        <?php   
            global $allSet;
            
            if($allSet){
                mailApply();
            }
            else{
                genApply();
            }
        ?>
    </div><!--page_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>