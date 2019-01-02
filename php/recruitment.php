<?php
$PAGE_TITLE='Recruitment';
?>

<!DOCTYPE html>
<head>
    <?php include 'head.php'; ?>
    <link rel="stylesheet" type="text/css" href="../css/recruit.css" />
    <script type="text/javascript" src="../javascript/jquery.js"></script>
    <script type="text/javascript" src='../javascript/recruit.js'></script>
    <script type="text/javascript" src="../javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="../javascript/smoothscroll.js"></script>
</head>
<body id='recruitment_0'>
    <?php include 'nav.php'; ?>
    <?php include 'recruitment_nav.php'; ?>
    <div id='photo' class='fade_full0'>
        <img src='../images/recruitment.png' class='banner_pic'  alt='recruit'>
    </div><!--photo-->
    <div id='page_layout' class='fade_full1'>
        <div id='righter'>
            <nav id="menu">
                <ul class="nav list-group">
                    <li class="list-group-item"><a href="#business" class="smoothScroll">Business</a></li>
                    <li class="list-group-item"><a href="#marketmedia" class="smoothScroll">Marketing</a></li>
                    <li class="list-group-item"><a href="#operations" class="smoothScroll">Operations</a></li>
                    <li class="list-group-item"><a href="#rd" class="smoothScroll">R &amp; D</a></li>
                </ul>
            </nav><!--menu-->       
        </div><!--righter-->
        <div id='other_content'>
            Working for Big Red Bikes, students have a unique chance to shape the campus as well as their professional persona. Leading these projects,
            each student is given the chance to develop their skills in:
            <ul class='circle_list'>
                <li><a href='#business' class='page_links smoothScroll'>Business</a> Management</li>
                <li>Urban Planning and Active Transport Policy</li>
                <li>Public Outreach and Grant Writing</li>
                <li><a href='#marketmedia' class='page_links smoothScroll'>Marketing</a> and Brand Management</li>
                <li>Logistics and <a href='#operations' class='page_links smoothScroll'>Operations</a> Management</li>
                <li><a href='#rd' class='page_links smoothScroll'>Research and Development</a></li>
                <li>Human Resource Management</li>
            </ul>
            New members will have the chance to take the lead on high profile projects and even start their own. We encourage new members to take on officer
            positions and even run for the co-president position for the next election term. Check the teams below or <a href='apply.php' class='page_links'>
            apply now</a>.
        </div><!--other_content-->
        <section id="categories">
            <h2 id="business">Business</h2>
                The Business team is one of three mutually interdependent teams that work collaboratively to achieve our goals. 
                This semester, the team's core responsibilities will be:
                <ul class='circle_list'>
                    <li>Developing and implementing the BRB business plan for this semester and as BRB expands</li>
                    <li>Developing and managing revenue sources</li>
                    <li>Working with the other teams to manage all expenditures and accounts</li>
                </ul>
                The Business Director is responsible for managing this integral part of a dynamic and collaborative organization. 
                S/he sets Big Red Bikes business strategy and assigns team members to projects, making sure that all members are 
                challenged and have the chance to innovate and gain professional experience.
            <br/>
            <h2 id="marketmedia">Marketing &amp; Media</h2>
                The Marketing &amp; Media team is one of four mutually interdependent teams that work collaboratively to achieve our 
                goals. This semester, the team's core responsibilities will be:
                <ul class='circle_list'>
                    <li>Developing and implementing a marketing strategy for BRB and its services</li>
                    <li>Designing and distributing informational and promotional material (digital, print,etc.)</li>
                    <li>Manages list serves and all external communications including social media and the BRB website</li>
                </ul>
                The Marketing &amp; Media Director is responsible for managing this integral part of a dynamic and collaborative 
                organization. S/he sets Big Red Bikes' Marketing strategy and assigns team members to projects making sure that 
                all members are challenged and have the chance to innovate as well as gain professional experience.
            <br/>
            <h2 id="operations">Operations</h2>
                The Operations team is one of four mutually interdependent teams that work collaboratively to achieve our goals. 
                This semester, the team's core responsibilities will be:
                <ul class='circle_list'>
                    <li>Maintaining and monitoring the bike fleet</li>
                    <li>Managing logistics and re-balancing stations</li>
                    <li>Routine Data/Performance analysis for system optimization</li>
                    <li>Managing the check-out system and overseing the implementation of any new services</li>
                    <li>Collaborating with BRB's partners to develop a new operations procedure for an automated check-out system</li>
                    <li>Planning new stations on campus with an automated check-out system</li>
                </ul>
                The Operations Director (paid)  is responsible for managing this integral part of a dynamic and collaborative 
                organization. S/he implements the Big Red Bikes Operations Procedure, overseeing station managers and assigning projects 
                to team members which are challenging and innovativee.
            <br/><b>Positions:</b> The operations team has several specialized positions in addition to general staff members, including:
                <ul class='circle_list'>
                    <li>Station Managers - Manages and monitors the customer interface at BRB stations including the check-out 
                        process and all equipment. Responsible for keeping service at stations convenient, reliable and safe.</li>
                    <li>(Paid) Maintenance Technicians - Responsible for ensuring excellent rider safety and fleet performance. Please contact 
                        <a class='page_links' href="mailto:bigredbikesrecruitment@gmail.com">bigredbikesrecruitment@gmail.com</a> for more information.</li>
                </ul>
            <h2 id="rd">Research &amp; Development</h2>
            The Research and Development will spearhead the development of an automated bike share check-out system which may one 
            day compete with existing bike share systems as an opensource and user friendly alternative. The new check-out system 
            will emphasize user accesibility, physical flexibility and powerful management capabilities. As part of this, students on 
            the research and development team will create the mechanical, electrical and software systems that support the functions 
            listed below:
               <ul class='circle_list'>
                   <li>Instant bike check-out using Student ID scanners</li>
                   <li>Real-time bike availability maps</li>
                   <li>Tracking bikes using RFID or GPS technology</li>
                   <li>Secure and aesthetically pleasing locking mechanisms</li>
                   <li>Web-based management and analytics software</li>
               </ul>
           <br/>
           <br/>
            <p class='center'><a href='apply.php' class='page_links large_font'>Apply Now!</a></p>
        </section>
        <div id='clear_both'>&nbsp;</div>
    </div><!--page_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>