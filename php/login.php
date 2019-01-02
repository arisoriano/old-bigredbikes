<?php
ob_start();
$PAGE_TITLE='Login';
?>
<!DOCTYPE html>
<head>
    <?php include 'head.php'; ?>
</head>
<?php 
       
    
    $warn= "";      
    
    //Attempt login 
    if(isset($_POST['email']) && isset($_POST['pwd'])) {
        //Prep username and password
        $user = trim(strip_tags($_POST['email']));
        $pwd = trim(strip_tags($_POST['pwd']));

        //Check if fields are nonempty
        if(strlen($user)==0||strlen($pwd)==0){
            $warn='Please enter a username and password.';
        }
        
        else{
            $pwd = hash('sha256', $pwd.SALT);
            //Use prepared statement to attempt login
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);    
            $query= "SELECT * FROM BikeshareUsers WHERE email=? AND password=?;";
            $stmt= $db->prepare($query);
            $stmt->bindParam(1, $user);
            $stmt->bindParam(2, $pwd);
            $stmt->execute();
            if($row= $stmt->fetch(PDO::FETCH_ASSOC)){  
                $_SESSION['user']=$row['email'];
                $_SESSION['lvl']=$row['permission_level'];
		  header('Location:index.php');
                $time= date("Y-m-d H:i:s");
                $query= "UPDATE BikeshareUsers SET last_login='$time' WHERE email=? AND password=?;";
                $stmt2= $db->prepare($query);
                $stmt2->bindParam(1, $user);
                $stmt2->bindParam(2, $pwd);
                $stmt2->execute();
                //Redirect depending on access level
                header('Location:account.php');
            }
            //No username/password found
            else{
                $warn= "Username and/or password is invalid.";
            } 
        }
    }


    function show_login(){
        //Check if already logged in
        if(isset($_SESSION['user'])){
            echo "<p>You are logged in as ". $_SESSION['user']."</p>";
            echo "<a href='logout.php' class='page_links'>Logout</a>";
        }
        //Display login page.
        else{
            global $warn;
            echo "<p><span class='red'>$warn</span></p>";
            echo '<form action="login.php" method="post"> 
                <table>
                <tr>
                    <td>Email: </td>
                    <td><input type="email" name="email" size="30"/></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="pwd" size="30" maxlength="30" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><span class="small_font">Forget your username or password? Click <a href="reset.php" class="page_links">here</a> for help.
                    </span></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Login"/></td>
                </tr>
                </table> 
            </form>';
        }
    }
    
?>

<body>
    <div id='header_login'>
            <?php include 'nav.php'; ?>
    </div><!--header-->
    <div id='photo' class='fade_full0'>
        <img src='../images/login.png' class='banner_pic'  alt='login'>
    </div><!--photo-->
    <div id='page_layout' class='fade_full1'>
        
    <div id="login">
        <?php
            show_login();
        ?> 

        </div>

    </div><!--page_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>