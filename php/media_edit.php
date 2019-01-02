<?php
$PAGE_TITLE='Media Editor';
//This is an invisible page to users; only admins can see this page
//This page serves for clients to be able to add future media to the site easily without coding knowledge
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; 
 
     if(!isset($_SESSION['user'])||$_SESSION['lvl']!="Manager"){
        header('Location: denied.php');
        die();
    }
    ?>
    <link type='text/css' rel='stylesheet' href='../css/media.css'/>
    <link type='text/css' rel='stylesheet' href='../css/bootstrap.css'/>
</head>
<body id='media_edit_0'>
    <?php
    $checkErrors=FALSE;
    $correctErrors='';
    $added='';
    $tError='';
    $mError='';
    $dError='';
    $yError='';
    $meError='';
    $uError='';
    $bError='';

    //Sanitizer function for text inputs
    function remove_bad($data) {
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }
    
    if(isset($_POST['submit'])){
        if(strlen($_POST['title'])==0){
            $tError=' *title cannot be left blank';
            $checkErrors=TRUE;
        }
        
        if(strlen($_POST['month'])==0){
            $mError=' *a month must be selected';
            $checkErrors=TRUE;
        } 
        
        if(strlen($_POST['day'])==0){
            $dError=' *a day must be selected';
            $checkErrors=TRUE;
        } 
        
        if(strlen($_POST['year'])==0){
            $yError=' *a year must be selected';
            $checkErrors=TRUE;
        } 
        
        if(strlen($_POST['company'])==0){
            $meError=' *a media source must be selected';
            $checkErrors=TRUE;
        } 
        
        if(strlen($_POST['url'])==0){
            $uError=' *url cannot be left blank';
            $checkErrors=TRUE;
        }
        
        if(strlen($_POST['blurb'])==0){
            $bError=' *blurb cannot be left blank';
            $checkErrors=TRUE;
        }
        
        if($checkErrors){
            $correctErrors='CORRECT ALL ERRORS BEFORE RESUBMITTING FORM';
        } 
        //Attempt to add to database
        else{
            $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $query="INSERT INTO Media (title, date, company, url, blurb) VALUES (?,?,?,?,?);";
            $date=remove_bad($_POST['year']).'-'.remove_bad($_POST['month']).'-'.remove_bad($_POST['day']);
            $title= remove_bad($_POST['title']);
            $company= remove_bad($_POST['company']);
            $url=remove_bad($_POST['url']);
            $blurb=remove_bad($_POST['blurb']);
            $stmt= $db->prepare($query);
            $stmt->bindParam(1, $title);
            $stmt->bindParam(2,$date);
            $stmt->bindParam(3, $company);
            $stmt->bindParam(4, $url);
            $stmt->bindParam(5, $blurb);
            $stmt->execute();
            $result= $stmt->rowCount();
            if($result!=0){
               $added='Your article has been added. You an add another article below.';
            }
            else{
                $correctErrors='An error occurred.';
            }

        }
    }
    
    //For deletions
    if(isset($_POST['delete'])){
        $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $query="DELETE FROM Media WHERE title=?;";
        foreach($_POST['toDelete'] as $val){
            $stmt= $db->prepare($query);
            $stmt->bindParam(1, $val);
            $stmt->execute();    
        }
    }
    
    ?>

    <?php include 'nav.php'; include 'admin_nav.php';?>
    <div id='no_header_layout'>
        <h1>Media Editor Form for Articles About BRB</h1>
        <br/>
        <p><?php echo $added; ?></p>
        <form action='media_edit.php' method="post" name="form">
            
            Enter title of the article <span class='red'>(no more than 70 characters)</span>: <input type='text' name='title' maxlength='70' size='70'
            required/>
            <?php echo "<br/><span class='red'>$tError</span>"; ?>
            <br/>
            Enter the date that the article was published by filling out the following:<br/>
            Month:&nbsp;
            
            <select name='month'>
                <option selected value=''>MM</option>
            <?php
            for($i=1;$i<=12;$i++){
                echo "<option value='$i'>$i</option>";
                }
            echo "</select>";
            echo "<span class='red'>$mError</span>";
            ?>
                
            &nbsp;Day:&nbsp;
            <select name='day'>
                <option selected value=''>DD</option>
            <?php
            for($i=1;$i<=31;$i++){
                echo "<option value='$i'>$i</option>";
                }
            echo "</select>";
            echo "<span class='red'>$dError</span>";
            ?>
                
            &nbsp;Year:&nbsp;
            <select name='year'>
                <option selected value=''>YYYY</option>
            <?php
            for($i=2008;$i<=2028;$i++){
                echo "<option value='$i'>$i</option>";
                }
            echo "</select>";
            echo "<span class='red'>$yError</span>";
            ?>
            
            <br/><br/>
            Choose article / media company type:
            <select name='company'>
                <option selected value=''>------------select media source------------</option>
                <option value='sun'>Cornell Daily Sun</option>
                <option value='chronicle'>Cornell Chronicle</option>
                <option value='other'>Other Newspaper Company</option>
                <option value='radio'>Video / Radio (e.g. YouTube or local station)</option>
            </select>
            <?php echo "<span class='red'>$meError</span>"; ?>
            <br/><br/>
            Enter the article url:
            <input type='url' name='url' size='60'/><?php echo "<span class='red'>$uError</span>"; ?><br/><br/>
            Enter a short blurb or excerpt about the article <span class='red'>(no more than 300 characters)</span>:
            <?php echo "<br/><span class='red'>$bError</span><br/>"; ?>
            <textarea name='blurb' maxlength='300' rows='3' cols='80'></textarea><br/><br/>
            <?php echo "<p class='red'>$correctErrors</p>"; ?>
            <input type="submit" name='submit' value="Submit"><input type="reset" value="Reset">
        </form>
        <br/>
        <br/>
        <h1>Delete a Media Article</h1>
        <br/>
        <form action="media_edit.php" method="post">
            <table>
            <?php
                $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
                $query= "SELECT title FROM Media ORDER BY date DESC;";
                $stmt= $db->prepare($query);
                $stmt->execute();
                while($entry= $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo '<tr><td><p>'.$entry['title'].'</p></td>
                    <td><p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="toDelete[]" value="'.$entry['title'].'"/></p></td>
                    </tr>';
                }
            ?>
            </table>
            <br/>
            <input type="submit" name="delete" value="Delete" />
        </form>
        <br/>
    </div><!--no_header_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>