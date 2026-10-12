<?php
$pageTitle = "Home";
$pageCss = ["home.css"];
$active = "home";
$bodyBg = "#F2EBD8";
require __DIR__ . "/includes/header.php";
?>

    <div class="content1">

        <div class="words">
            <h2>Make a Difference, One Donation at a Time.</h2>

            <p>TIME2HELP is a community donation initiative dedicated to making a positive difference in the lives of
                others.
                We aim to help those in need <br> through financial donations, essential supplies, and volunteer
                efforts.
                By coming together and sharing what we can, we hope to strengthen our <br> community and create
                meaningful
                change—one act of kindness at a time.</p>
        </div>

    </div>


    <div class="content2">

        <div class="content_img">
            <img src="Homapage.png" alt="Content Image">
        </div>

        <div class="fdr">
            <div class="donator">
                <a href="loginuser--signup.php?role=donator" class="role-btn">
                    First Time Donator
                </a>
            </div>

            <div class="recipient">
                <a href="loginuser--signup.php?role=recipient" class="role-btn">
                    First Time Recipient
                </a>
            </div>
        </div>

    </div>



    


<?php require __DIR__ . "/includes/footer.php"; ?>
