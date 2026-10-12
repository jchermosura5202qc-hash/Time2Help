<?php
$pageTitle = "About Us";
$pageCss = ["aboutus.css"];
$active = "about";
$bodyBg = "#F2EBD8";
require __DIR__ . "/includes/header.php";
?>

    <!-- ABOUT US INTRODUCTION -->
    <section class="about-intro">

        <!-- LEFT SIDE: HEADING AND DESCRIPTION -->
        <div class="about-text">
            <h1>ABOUT US</h1>

            <p>
                TIME2HELP is a website that connects volunteers with people or
                organizations who need help, making it easy to donate time, skills,
                cash, or goods to the community. Users can post requests for
                assistance or browse available requests and offer to help, track their
                scheduled activities, and see their contributions reflected on a
                leaderboard that recognizes active volunteers. Admins manage the
                platform behind the scenes, verifying users and donations, organizing
                requests, and keeping everything running smoothly and safely. The
                goal of the project is simple: make it easier for people to help each
                other and build a stronger, more connected community.
            </p>
        </div>

        <!-- RIGHT SIDE: IMAGE -->
        <div class="about-image">
            <img src="home.png" alt="Community space overlooking the ocean">
        </div>

    </section>


    <!-- MISSION AND VISION SECTION -->
    <section class="mission-vision">

        <!-- OUR MISSION CARD -->
        <div class="mission-card">

            <div class="mission-title">
                <img src="" alt="">
                <h2>Our Mission</h2>
            </div>

            <hr>

            <p>
                To connect volunteers and communities through a safe and
                accessible platform that makes donating time, skills, money,
                and goods easier for everyone.
            </p>

        </div>

        <!-- OUR VISION CARD -->
        <div class="vision-card">

            <div class="vision-title">
                <img src="" alt="">
                <h2>Our Vision</h2>
            </div>

            <hr>

            <p>
                We picture barangays across the Philippines where helping a neighbor is part of everyday life, and where anyone who needs support knows exactly where to ask.
            </p>

        </div>

    </section>



    <!-- FEEDBACK / TESTIMONIALS SECTION -->
    <section class="feedback-section">

        <h2>TESTIMONIES/FEEDBACK</h2>

        <div class="feedback-container">

            <!-- FIRST FEEDBACK CARD -->
            <div class="feedback-card">

                <div class="feedback-profile">
                    <img src="profile1.png" alt="Volunteer profile">

                    <div class="profile-info">
                        <h3>Alex Johnson</h3>
                        <p>Volunteer</p>
                    </div>
                </div>

                <div class="feedback-stars">
                    ★★★★★
                </div>

                <p class="feedback-message">
                    TIME2HELP made it easy for me to find opportunities
                    to help people in my community. I'm happy to be
                    part of something meaningful.
                </p>

            </div>

            <!-- SECOND FEEDBACK CARD -->
            <div class="feedback-card">

                <div class="feedback-profile">
                    <img src="profile2.png" alt="Donor profile">

                    <div class="profile-info">
                        <h3>Maria Santos</h3>
                        <p>Donor</p>
                    </div>
                </div>

                <div class="feedback-stars">
                    ★★★★★
                </div>

                <p class="feedback-message">
                    I appreciate how easy it is to share donations
                    with people who need them. The platform makes
                    helping others more convenient.
                </p>

            </div>

            <!-- THIRD FEEDBACK CARD -->
            <div class="feedback-card">

                <div class="feedback-profile">
                    <img src="profile3.png" alt="Community recipient profile">

                    <div class="profile-info">
                        <h3>John Reyes</h3>
                        <p>Community Member</p>
                    </div>
                </div>

                <div class="feedback-stars">
                    ★★★★★
                </div>

                <p class="feedback-message">
                    TIME2HELP helps bring people together. It's
                    encouraging to see volunteers and donors working
                    together to support our community.
                </p>

            </div>

        </div>

    </section>



    


<?php require __DIR__ . "/includes/footer.php"; ?>
