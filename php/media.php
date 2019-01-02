<?php
$PAGE_TITLE='About';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; ?>
    <link type='text/css' rel='stylesheet' href='../css/media.css'/>
</head>
<body id='media_page_0'>
    <?php include 'nav.php'; ?>
    <?php include 'about_nav.php'; ?>
    <div id='photo' class='fade_full1'>
        <img src='../images/media.png' class='banner_pic' alt='media'/>
    </div><!--photo-->
    <div id='page_layout' class='fade_full0'>
        Join our listserve and visit our Facebook and Twitter pages. Read up on news about Big Red Bikes below!<br/><br/><br/>
        <div id='social'>
            <div id='social_1'><a href="mailto:bigredbikes-l-request@cornell.edu?Subject=join" target="_top">
            <img src='../images/listserve.jpg' class='square' alt='listserve'/></a></div><!--social_1-->
            <div id='social_2'><a href='https://www.facebook.com/cubigredbikes' target='_blank'>
            <img src='../images/fb.png' class='square' alt='fb'/></a></div><!--social_2-->
            <div id='social_3'><a href='https://twitter.com/bigredbikes' target='_blank'>
            <img src='../images/twitter.png' class='square' alt='twitter'/></a></div><!--social_3-->
        </div><!--social-->
        <p></p>
        <br/>
    <?php
 
    $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
    $query= "SELECT * FROM Media ORDER BY date DESC;";
    $stmt= $db->prepare($query);
    $stmt->execute();
    while($entry= $stmt->fetch(PDO::FETCH_ASSOC)){  
        if($entry['company']=='sun'){
                $thumbnail="<img src='../images/sun.png' class='thumb' alt='sun'/>";
            }
            
            elseif($entry['company']=='chronicle'){
                $thumbnail="<img src='../images/chronicle.png' class='thumb' alt='chroncile'/>";
            }
            
            elseif($entry['company']=='radio'){
                $thumbnail="<img src='../images/radio.png' class='thumb' alt='radio'/>";
            }
            
            elseif($entry['company']=='other'){
                $thumbnail="<img src='../images/othernews.png' class='thumb' alt='other'/>";
            }
            
            $yr_end=substr($entry['date'],2,2);
            $month=substr($entry['date'],5,2);
            $day=substr($entry['date'],8,2);
            echo
            
            "<a class='plain' href='".$entry['url']."' target='_blank'>
            <div class='media'>
                <div class='media_header'><div class='title'><strong>".$entry['title']."
                </strong></div><!--title--><div class='date'><strong>$month&#8226;$day&#8226;$yr_end
                </strong></div><!--date--></div><!--media_header-->
                <div class='media_body'><div class='thumbnail'>$thumbnail</div><!--thumbnail--><div class='blurb'>".$entry['blurb']."...</div><!--blurb'-->  
                </div><!--media_body-->
            </div><!--media-->
            </a>";
            
    }
    
 ?>
    
    
    </div><!--page_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>