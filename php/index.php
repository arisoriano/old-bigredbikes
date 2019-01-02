<?php
$PAGE_TITLE='Home';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <script src="../javascript/jquery-2.0.3.js"></script>
    <script src="../javascript/bootstrap.js"></script>
    <script src="../javascript/carousel.js"></script>
</head>
<body>
    <div class="hidden" style="display:none;">
    <script type="text/javascript">
        window.onload = function() {
          setTimeout(function() {
            // preload image
            new Image().src = "../images/slide_1.jpg";
          }, 1000);
        };
      <!--//--><![CDATA[//><!--

        if (document.images) {
          imga = new Image();
          imgb = new Image();
          imgc = new Image();
          imgd = new Image();
          img1 = new Image();
          img2 = new Image();
          img3 = new Image();
          img4 = new Image();
          img5 = new Image();
          img6 = new Image();
          img7 = new Image();
          img8 = new Image();
          img9 = new Image();
          img10 = new Image();
          img11 = new Image();
          img12 = new Image();
          img13 = new Image();
          img14 = new Image();


          imga.src = "../images/slide_1.jpg";
          imgb.src = "../images/slide_2.jpg";
          imgc.src = "../images/slide_3.jpg";
          imgd.src = "../images/slide_4.jpg";
          img1.src = "../images/about.png";
          img2.src = "../images/apply.png";
          img3.src = "../images/bikes.png";
          img4.src = "../images/contact.png";
          img5.src = "../images/donate.png";
          img6.src = "../images/faq.png";
          img7.src = "../images/how.png";
          img8.src = "../images/login.png";
          img9.src = "../images/media.png";
          img10.src = "../images/models.png";
          img11.src = "../images/recruitment.png";
          img12.src = "../images/register.png";
          img13.src = "../images/bikes.png";
          img14.src = "../images/system.png";
        }

      //--><!]]>
    </script>
    </div>
    <?php include 'nav.php'; ?>
    <?php
    $mysqli= new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $res= $mysqli->query("SELECT open FROM Status");      
    $open= $res->fetch_row();
    if($open[0]){
        echo "<div id='home_page_open' class='fade_full0'>";
    }
    else{
        echo "<div id='home_page_closed' class='fade_full0'>";
    }
    ?>
        <div id="index_banner" class="carousel slide" data-ride="carousel">
         <!-- Indicators -->
         <!--
         <ol class="carousel-indicators">
           <li data-target="#index_banner" data-slide-to="0" class="active"></li>
           <li data-target="#index_banner" data-slide-to="1"></li>
           <li data-target="#index_banner" data-slide-to="2"></li>
         </ol>
         -->
       
         <!-- Wrapper for slides -->
         <div class="carousel-inner">
           <div class="item active">
             <a href='register.php'><img src="../images/slide_1.jpg" alt="slide1"></a>
       <!-- 		<div class="carousel-caption">
                       <h3>Media</h3>
                       <p>First Image.</p>
               </div> -->
           </div>
           <div class="item">
             <a href='donate.php'><img src="../images/slide_3.jpg" alt="donate"></a>
       <!-- 		<div class="carousel-caption">
                       <h3>Donate</h3>
                       <p>Second Image.</p>
               </div> -->
           </div>
           <div class="item">
             <a href='bikes.php'><img src="../images/slide_2.jpg" alt="locations"></a>
       <!-- 		<div class="carousel-caption">
                       <h3>About</h3>
                       <p>Third Image.</p>
               </div> -->
           </div>
           <div class="item">
             <a href='how.php'><img src="../images/slide_4.jpg" alt="bikesharing"></a>
       <!-- 		<div class="carousel-caption">
                       <h3>About</h3>
                       <p>Third Image.</p>
               </div> -->
           </div>
         </div>
       
         <!-- Controls -->
          <a class="left carousel-control" href="#index_banner" data-slide="prev">
           <span class="glyphicon glyphicon-chevron-left"></span>
         </a>
         <a class="right carousel-control" href="#index_banner" data-slide="next">
           <span class="glyphicon glyphicon-chevron-right"></span>
         </a> 
        </div><!-- Carousel -->
        <div id='home_container'>
            <div id='home_1'><a href='about.php'><img src='../images/home_1.png' class='home_blurb' alt='home_1'></a></div>
            <div id='home_2'><a href='media.php'><img src='../images/home_2.png' class='home_blurb' alt='home_2'></a></div>
            <div id='home_3'><a href='recruitment.php'><img src='../images/home_3.png' class='home_blurb' alt='home_3'></a></div>
        </div><!--home_container-->
    </div><!--home_page-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>