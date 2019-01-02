<div id='footer_table'>
    <div id='cell_00'>
        <a href='http://www.cornell.edu' target='_blank'><img src='../images/cornell_seal_white.png' alt='seal' class='rollover'></a>
    </div><!--cell_00-->
    <div id='cell_0'>
        <a href='how.php'>Bike Sharing</a><br/>
        <a href='system.php'>Our System</a><br/>
        <a href='models.php'>Bike Models</a><br/>
        <a href='faq.php'>FAQ</a>
    </div><!--cell_1-->
    <div id='cell_1'>
        <a href='about.php'>About Us</a><br/>
        <a href='media.php'>Media</a><br/>
        <a href='recruitment.php'>Recruitment</a><br/>
        <a href='apply.php'>Apply Now</a>
    </div><!--cell_1-->
    <div id='cell_2'>
        <?php
        if(isset($_SESSION['user'])){
            echo
            "<a href='accountuser.php'>My Account</a><br/><a href='logout.php'>Logout</a><br/><a href='contact.php'>Contact Us</a>";
        } else{
            echo"<a href='login.php'>Login</a><br/><a href='register.php'>Sign Up</a><br/><a href='contact.php'>Contact Us</a>";
        }
        ?>
    </div><!--cell_2-->
    <div id='cell_3'>
        <a href='https://www.facebook.com/cubigredbikes' target='_blank'>
        <img src='../images/fb_button_hover.png' class='rollover' alt='fb' title='facebook'></a>
    </div><!--cell_3-->
    <div id='cell_4'>
        <a href='https://twitter.com/bigredbikes' target='_blank'>
        <img src='../images/twitter_button_hover.png' class='rollover' alt='tweet' title='twitter'></a>
    </div><!--cell_4-->
</div><!--footer_table-->
<div id='copyright'>
    &#169; 2014 Big Red Bikes
</div><!--copyright-->