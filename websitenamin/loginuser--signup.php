<?php
session_start();

$signupError = "";
$signupSuccess = "";
$loginError = "";
$registrationComplete = false;

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    ($_POST["form_type"] ?? "") === "signup"
) {
    require_once "db.php";

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $termsAccepted = isset($_POST["remember"]);

    if ($name === "" || $email === "" || $password === "") {
        $signupError = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signupError = "Please enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $signupError = "Your password must be at least 8 characters.";
    } elseif (!$termsAccepted) {
        $signupError = "Please agree to the terms and policy.";
    } else {
        try {
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO users (name, email, password)
                    VALUES (:name, :email, :password)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":password" => $hashedPassword
            ]);

            $registrationComplete = true;

        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $signupError = "That email address is already registered.";
            } else {
                error_log($e->getMessage());
                $signupError = "Something went wrong. Please try again.";
            }
        }
    }
} // End of signup handler

// LOGIN HANDLER
if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    ($_POST["form_type"] ?? "") === "login"
) {
    require_once "db.php";

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $sql = "SELECT id, name, email, password
        FROM users
        WHERE email = :email
        LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (
        $user &&
        
        password_verify($password, $user["password"])
    ) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];

        header("Location: userprof.php");
        exit;
    } else {
        $loginError = "Invalid name, email, or password.";
    }
}
?>

<?php
$pageTitle = "Log In / Sign Up";
$pageCss = ["loginuser--signup.css"];
$active = "";
$bodyBg = "#C9D8A5";
require __DIR__ . "/includes/header.php";
?>

    <!--SIGNUP FORM-->
    <div class="back_box">
        <div class="welcom">
            <p>Welcome back! Sign in to continue supporting causes that matter.</p>
        </div>

        <div class="divider">

        </div>

        <div id="signform" class="signform">
            <div class="welcome_header">
                <h2>Get Started Now</h2>
            </div>

            <?php if ($signupError !== ""): ?>
                <p class="form-error">
                    <?= htmlspecialchars($signupError, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?>

            <?php if ($signupSuccess !== ""): ?>
                <p class="form-success">
                    <?= htmlspecialchars($signupSuccess, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?>



            <form action="" method="post">
                <input type="hidden" name="form_type" value="signup">

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
                        <a class="tp" href="#">terms &amp; policy</a>
                    </label>
                </div>

                <button class="btn" type="submit">Signup</button>

                <div class="or-divider">
                    <span>Or</span>
                </div>

                <div class="social-login">
                    <button type="button" class="social-btn">
                        <img src="google-svgrepo-com.svg" alt="" class="social-logo">
                        <span>Sign in with Google</span>
                    </button>

                    <button type="button" class="social-btn">
                        <img src="apple-svgrepo-com.svg" alt="" class="social-logo">
                        <span>Sign in with Apple</span>
                    </button>
                </div>

            </form>

            <p class="signin">
                Already have an account?
                <a href="#" onclick="togglelogform(event)">Sign In</a>
            </p>
        </div>

        <div class="pic">
            <img src="luser.png" alt="login">
        </div>



        <!--LOGIN FORM-->
        <div id="logform" class="logform">
            <div class="welcome_header">
                <h2>WELCOME BACK!</h2>
            </div>

            <?php if (!empty($loginError)): ?>
                <p style="color: red;">
                    <?= htmlspecialchars($loginError, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?>

            <form action="" method="post">
                <input type="hidden" name="form_type" value="login">

                

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
                    <button type="button" class="social-btn">
                        <img src="google-svgrepo-com.svg" alt="" class="social-logo">
                        <span>Sign in with Google</span>
                    </button>

                    <button type="button" class="social-btn">
                        <img src="apple-svgrepo-com.svg" alt="" class="social-logo">
                        <span>Sign in with Apple</span>
                    </button>
                </div>
            </form>

            <div class="forgot">
                <p>Don't have an account?
                    <a class="sign-up" href="#" onclick="togglelogform(event)">Sign Up</a>
                </p>

                <a class="fpass" href="#">Forgot Password?</a>
            </div>
        </div>
    </div>


    <script>
        // Get the signup and login forms
        const signform = document.getElementById('signform');
        const logform = document.getElementById('logform');

        // Check whether PHP confirmed successful registration
        const registrationComplete =
            <?php echo !empty($registrationComplete) ? 'true' : 'false'; ?>;

        const loginAttempted =
            <?php echo !empty($loginError) ? 'true' : 'false'; ?>;

        if (registrationComplete || loginAttempted) {
            signform.style.display = 'none';
            logform.style.display = 'block';
        } else {
            signform.style.display = 'block';
            logform.style.display = 'none';
        }

        // Switch between signup and login
        function togglelogform(event) {
            event.preventDefault();

            if (signform.style.display === 'none') {
                signform.style.display = 'block';
                logform.style.display = 'none';
            } else {
                signform.style.display = 'none';
                logform.style.display = 'block';
            }
        }
    </script>


    


<?php require __DIR__ . "/includes/footer.php"; ?>
