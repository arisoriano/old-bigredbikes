<div id='header'>
    <div id='top_page'>
        <div id='top_page_left'>
            <a href='index.php' class='no_hover'><img class='logo' src='../images/brb_logo_color.png' alt='logo'></a>
        </div>
        <?php 
            if(isset($_SESSION['user'])){
                echo "<div id='top_page_right'><a href='account.php'><img class='page_top' src='../images/account_text.png' alt='acct'/></a><a href='logout.php'><img class='page_top' src='../images/logout_text.png' alt='logout'/></a></div>";
            }
            else{
                echo "<div id='top_page_right'><a href='login.php'><img class='page_top' src='../images/login_text.png' alt='key'/></a><a href='register.php'><img class='page_top' src='../images/signup_text.png' alt='signup'/></a></div>";
            }
        ?>
    </div><!--top_page-->
    <?php
    $ACTIVE="class='active'";
    $home='';$bikes='';$how='';$donate='';$about='';$recruit='';$contact='';
    
    //highlights nav bar menu item when on the current page by setting li class
    //to 'active'
    if($PAGE_TITLE=='Home'){
        $home.=$ACTIVE;
    }
    elseif($PAGE_TITLE=='Bikes'){
        $bikes.=$ACTIVE;
    }
    elseif($PAGE_TITLE=='How'){
        $how.=$ACTIVE;
    }
    elseif($PAGE_TITLE=='Donate'){
        $donate.=$ACTIVE;
    }
    elseif($PAGE_TITLE=='About'){
        $about.=$ACTIVE;
    }
    elseif($PAGE_TITLE=='Recruitment'){
        $recruit.=$ACTIVE;
    }
    elseif($PAGE_TITLE=='Contact'){
        $contact.=$ACTIVE;
    }
    
    echo
    "<ul id='nav'>
    <li $home><a href='index.php'>Home</a></li>
    <li $about><a href='about.php'>About</a></li>
    <li $how><a href='how.php'>How it Works</a></li>
    <li $bikes><a href='bikes.php'>Bike Availability</a></li>
    <li $donate><a href='donate.php'>Donate</a></li>
    <li $recruit><a href='recruitment.php'>Recruitment</a></li>
    <li $contact><a href='contact.php'>Contact</a></li>
    </ul>";
    ?>
</div><!--header-->