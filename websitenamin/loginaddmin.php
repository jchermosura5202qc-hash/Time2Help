<?php
$pageTitle = "Admin Login";
$pageCss = ["loginaddmin.css"];
$active = "";
$bodyBg = "#F2EBD8";
require __DIR__ . "/includes/header.php";
?>

    <div class="login-page">

        <!-- LEFT SIDE: LOGIN FORM -->
        <div class="form-box">

            <form action="">

                <h1>TIME2HELP</h1>
                <h2>Welcome Back!</h2>

                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>

                <div class="input-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="policy">
                    <input type="checkbox" id="remember" name="remember" required>
                    <label for="remember">
                        I agree to the
                        <a href="terms_&_policy.html">terms &amp; policy</a>
                    </label>
                </div>

                <button class="btn" type="submit">Login</button>

                <div class="or-divider">
                    <span>Or</span>
                </div>

                <div class="social-login">
                    <button type="button"> Sign in with Google</button>
                    <button type="button"> Sign in with Apple</button>
                </div>

                <p class="forgot">
                    <a href="#">Forgot Password?</a>
                </p>

            </form>
        </div>

        <!-- RIGHT SIDE: IMAGE -->
        <div class="login-image">
            <img src="lpic.png" alt="Content Image">
        </div>

    </div>

<?php require __DIR__ . "/includes/footer.php"; ?>
