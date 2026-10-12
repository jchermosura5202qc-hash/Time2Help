<?php
$pageTitle = "Feedback";
$pageCss = ["feedback.css"];
$active = "";
$bodyBg = "#F2EBD8";
require __DIR__ . "/includes/header.php";
?>

    <main class="feedback-section">

        <div class="feedback">

            <h1>Feedback From</h1>

            <form action="#" method="POST">
                <div form-group>

                    <label for="username">Username</label>

                    <div class="input-wrapper">
                        <span class="input-icon">&#128100;</span>
                        <input placeholder="Enter your name" type="text" id="username" name="username" required>
                    </div>
                </div>

                <div class="form-group">

                    <label for="email">Email Address</label>

                    <div class="input-wrapper">
                        <span class="input-icon">&#9993;</span>
                        <input placeholder="Enter your email" type="email" id="email" name="email" required>
                    </div>
                </div>


                <div class="rating-section">
                    <p><b>Share your experience in scaling</p>

                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" required>
                        <label for="star5" title="5 stars">&#9733;</label>

                        <input type="radio" id="star4" name="rating" value="4" required>
                        <label for="star5" title="4 stars">&#9733;</label>

                        <input type="radio" id="star3" name="rating" value="3" required>
                        <label for="star5" title="3 stars">&#9733;</label>

                        <input type="radio" id="star2" name="rating" value="2" required>
                        <label for="star5" title="2 stars">&#9733;</label>

                        <input type="radio" id="star1" name="rating" value="1" required>
                        <label for="star5" title="1 stars">&#9733;</label>
                    </div>
                </div>

                <div class="comment">
                    <label for="comments" class="visually-hidden"></label>

                    <textarea id="comments" name="comments" placeholder="Add your comments.." maxlength="2000" required>
                    </textarea>
                </div>

                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="window.history.back">
                        CANCEL
                    </button>

                    <button type="submit" class="submit-btn">
                        SUBMIT
                    </button>
                </div>

            </form>
        </div>
    </main>




    


<?php require __DIR__ . "/includes/footer.php"; ?>
