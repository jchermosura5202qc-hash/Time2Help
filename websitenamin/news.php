<?php
$pageTitle = "News";
$pageCss = ["news.css"];
$active = "news";
$bodyBg = "#F2EBD8";
require __DIR__ . "/includes/header.php";
?>

    <!-- NEWS SECTION -->
    <main class="news-section">

        <div class="news-heading">
            <h1>LATEST UPDATES</h1>
        </div>

        <!-- NEWS CONTENT -->
        <div class="post-boxes">
            <div class="post-column">
                <div class="profile">
                    <img src="IMG_8957.jpg">

                    <div class="profile-info">
                        <h1>RENZO TABA</h1>
                        <small>Donator</small>
                    </div>
                </div>

                <hr>

                <h3>News Updates.</h3>
                <img class="ppost" src="IMG_8957.jpg">
            </div>

            <div class="post-column">
                <div class="profile">
                    <img src="IMG_8956.jpg">

                    <div class="profile-info">
                        <h1>Dim Crisostomo</h1>
                        <small>Requester</small>
                    </div>
                </div>

                <hr>

                <h3>Community event. </h3>
                <img class="ppost" src="pexels-ron-lach-9543732.jpg">
            </div>

            <div class="post-column">
                <div class="profile">
                    <img src="pexels-ron-lach-9543732.jpg">

                    <div class="profile-info">
                        <h1>James Labanza</h1>
                        <small>Donator</small>
                    </div>
                </div>

                <hr>

                <h3>lorem ipsum dolor sit amet </h3>
                <img class="ppost" src="IMG_8957.jpg">
            </div>
        </div>


        <div class="news-heading">
    <h1>Community Events</h1>
</div>

<div class="events">

    <div class="event-pic">
        <img src="pexels-ludawigakwana-12091690.jpg" alt="Community event">

        <div class="event-info">
            <h2>Community Clean-Up</h2>
            <p class="event-date">October 20, 2026</p>
            <p>Join us in keeping our community clean and beautiful.</p>
            <a href="#">Learn More</a>
        </div>
    </div>

    <div class="event-pic1">
        <img src="pexels-erickson-balderama-2636193-6829776.jpg" alt="Donation drive">

        <div class="event-info">
            <h2>Community Donation Drive</h2>
            <p class="event-date">October 25, 2026</p>
            <p>Share what you can and help families in need.</p>
            <a href="#">Learn More</a>
        </div>
    </div>

</div>
    </main>





    


<?php require __DIR__ . "/includes/footer.php"; ?>
