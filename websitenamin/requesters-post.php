<?php
$pageTitle = "Request Posts";
$pageCss = ["requesters-post.css"];
$active = "";
$bodyBg = "#F2EBD8";
require __DIR__ . "/includes/header.php";
?>

    <div class="post-header">

        <div class="search">
            <h1><strong>LASTEST UPDATES</strong></h1>

            <form class="search-bar" action="news.php" method="GET">
                <input type="search" name="search" placeholder="Search" aria-label="Search news">
                <button type="submit" aria-label="Search">
                    🔍
                </button>
            </form>
        </div>


        <div class="pc">
            <div class="pc-button">
                <a href="#">POST</a>
            </div>
            
            <div class="pc-button">
                <a href="#">POST</a>
            </div>
        </div>
    </div>



    <div class="content1">



    </div>



    


<?php require __DIR__ . "/includes/footer.php"; ?>
