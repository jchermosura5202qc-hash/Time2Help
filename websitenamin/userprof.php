<?php


session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: loginuser--signup.php");
    exit;
}

require_once "db.php";

$stmt = $pdo->prepare(
    "SELECT id, name, email, number, location, atype, bio, profile_photo
     FROM users
     WHERE id = :id
     LIMIT 1"
);

$stmt->execute([
    ":id" => $_SESSION["user_id"]
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

$profileMessage = "";
$profileError = "";

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["update_profile"])
) {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $number = trim($_POST["number"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $atype = trim($_POST["atype"] ?? "");
    $bio = trim($_POST["bio"] ?? "");

    if ($name === "" || $email === "") {
        $profileError = "Name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $profileError = "Please enter a valid email address.";
    } else {
        try {
            $stmt = $pdo->prepare(
                "UPDATE users
     SET name = :name,
         email = :email,
         number = :number,
         location = :location,
         atype = :atype,
         bio = :bio
     WHERE id = :id"
            );

            $stmt->execute([
                ":name" => $name,
                ":email" => $email,
                ":number" => $number,
                ":location" => $location,
                ":atype" => $atype,
                ":bio" => $bio,
                ":id" => $_SESSION["user_id"]
            ]);

            // Update the displayed profile information
            $user["name"] = $name;
            $user["email"] = $email;
            $user["number"] = $number;
            $user["location"] = $location;
            $user["atype"] = $atype;
            $user["bio"] = $bio;

            $profileMessage = "Profile updated successfully!";
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $profileError = "That email address is already in use.";
            } else {
                error_log($e->getMessage());
                $profileError = "Unable to update your profile. Please try again.";
            }
        }
    }
}

if (!$user) {
    session_unset();
    session_destroy();

    header("Location: loginuser--signup.php");
    exit;
}
?>

<?php
$pageTitle = "My Profile";
$pageCss = ["userprof.css"];
$active = "";
$bodyBg = "";
require __DIR__ . "/includes/header.php";
?>

    <main class="content1">

        <section class="profile-card">

            <!-- PROFILE TOP BAR -->
            <div class="profile-top">

                <!-- Name and date: LEFT SIDE -->
                <div class="welcome">
                    <h2>Welcome, <?= htmlspecialchars($user["name"], ENT_QUOTES, "UTF-8") ?></h2>

                    <?php
                    date_default_timezone_set("Asia/Manila");
                    echo date("l, F d, Y");
                    ?>
                </div>

                <div class="profile-actions">




                    <!-- Notification bell: RIGHT SIDE -->
                    <div class="notification-wrapper">

                        <button class="icon-button" type="button" id="notificationBell" aria-label="Notifications"
                            aria-expanded="false" aria-controls="notificationDropdown">
                            <img src="bell.svg" alt="" class="bell-image">
                        </button>

                        <!-- Notification dropdown -->
                        <div class="notification-dropdown" id="notificationDropdown" hidden>

                            <div class="notification-header">
                                <h3>Notifications</h3>
                            </div>

                            <div class="notification-list">

                                <div class="notification-item unread">
                                    <span class="notification-dot"></span>
                                    <div>
                                        <strong>CERTIFICATE PDF</strong>
                                        <small>Certificate Update</small>
                                    </div>
                                </div>

                                <div class="notification-item unread">
                                    <span class="notification-dot"></span>
                                    <div>
                                        <strong>FINISH LOG-IN INFO</strong>
                                        <small>Account Reminder</small>
                                    </div>
                                </div>

                                <div class="notification-item unread">
                                    <span class="notification-dot"></span>
                                    <div>
                                        <strong>DONATE REQUEST APPROVED!</strong>
                                        <small>Account Update</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- BACK -->
                    <button class="icon-button back-button" type="button" onclick="window.location.href='logout.php'"
                        aria-label="Log out">
                        <img src="back-entrance-exit-logout-quit-svgrepo-com.svg" alt="" class="back-image">
                    </button>
                </div>

            </div>
            <!-- END PROFILE TOP BAR -->

            <!-- PROFILE CONTENT -->
            <div class="profile-body">

                <!-- USER NAME AND EDIT BUTTON -->
                <div class="user-heading">

                    <div class="user-identity">

                        <div class="profile-picture-container">
                            <img src="<?= !empty($user['profile_photo'])
                                ? htmlspecialchars($user['profile_photo'], ENT_QUOTES, 'UTF-8')
                                : 'home1.png' ?>"
                                alt="<?= htmlspecialchars($user["name"], ENT_QUOTES, "UTF-8") ?>"
                                class="profile-picture" id="profileImage">

                            <form action="upload_photo.php" method="POST" enctype="multipart/form-data">

                                <button type="button" id="editPhotoBtn" class="change-photo-btn">
                                    Edit Photo
                                </button>

                                <input type="file" name="profile_photo" id="photoInput"
                                    accept="image/jpeg,image/png,image/webp" hidden required>

                                <button type="submit" id="uploadPhotoBtn" class="change-photo-btn" hidden>
                                    Save Photo
                                </button>

                            </form>
                        </div>

                        <span class="user-name">
                            <?= htmlspecialchars($user["name"], ENT_QUOTES, "UTF-8") ?>
                        </span>

                    </div>

                    <button type="button" id="editProfileBtn">
                        Edit
                    </button>

                </div>

                <!-- EDIT PROFILE FORM: ADD HERE -->
                <?php if ($profileMessage !== ""): ?>
                    <p style="color: green;">
                        <?= htmlspecialchars($profileMessage, ENT_QUOTES, "UTF-8") ?>
                    </p>
                <?php endif; ?>

                <?php if ($profileError !== ""): ?>
                    <p style="color: red;">
                        <?= htmlspecialchars($profileError, ENT_QUOTES, "UTF-8") ?>
                    </p>
                <?php endif; ?>
                <form id="editProfileForm" method="POST" action="">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name"
                        value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="number">Phone Number: </label>
                    <input type="text" id="number" name="number"
                        value="<?= htmlspecialchars($user['number'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="location">Location: </label>
                    <input type="text" id="location" name="location"
                        value="<?= htmlspecialchars($user['location'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="atype">Account Type: </label>
                    <input type="text" id="atype" name="atype"
                        value="<?= htmlspecialchars($user['atype'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <label for="bio">Bio: </label>
                    <input type="text" id="bio" name="bio"
                        value="<?= htmlspecialchars($user['bio'], ENT_QUOTES, 'UTF-8') ?>" required>

                    <button type="submit" name="update_profile">
                        Save Changes
                    </button>

                    <button type="button" id="cancelEditBtn">
                        Cancel
                    </button>
                </form>


                <!-- TWO-COLUMN PROFILE SECTIONS -->
                <div class="profile-sections">

                    <!-- BASIC INFORMATION -->
                    <section class="info-panel">
                        <h4>BASIC INFORMATION</h4>

                        <div class="info-field">
                            <span>Full Name: <?= htmlspecialchars($user["name"], ENT_QUOTES, "UTF-8") ?></span>
                            <button type="button" aria-label="Edit full name"></button>
                        </div>

                        <div class="info-field">
                            <span>Email: <?= htmlspecialchars($user["email"], ENT_QUOTES, "UTF-8") ?></span>
                            <button type="button" aria-label="Edit email"></button>
                        </div>

                        <div class="info-field">
                            <span>Phone Number:
                                <?= htmlspecialchars($user["number"] ?? "", ENT_QUOTES, "UTF-8") ?></span>
                        </div>

                        <div class="info-field">
                            <span>Location:
                                <?= htmlspecialchars($user["location"] ?? "", ENT_QUOTES, "UTF-8") ?></span>
                        </div>

                        <div class="info-field">
                            <span>Account Type:
                                <?= htmlspecialchars($user["atype"] ?? "", ENT_QUOTES, "UTF-8") ?></span>
                        </div>

                        <div class="info-field">
                            <span>Bio: <?= htmlspecialchars($user["bio"] ?? "", ENT_QUOTES, "UTF-8") ?></span>
                        </div>

                        <div class="history-field">
                            <div class="history-heading">
                                <span>DONATION / REQUEST HISTORY</span>
                                <button type="button" aria-label="Edit history"></button>
                            </div>

                            <div class="history-content">


                                <!-- Add donation and request records here -->


                            </div>
                        </div>

                    </section>

                    <!-- PERSONAL POSTS -->
                    <section class="posts-panel">
                        <h4>PERSONAL POSTS</h4>

                        <div class="posts-container">

                            <article class="post-card">
                                <div class="post-heading">
                                    <img src="home1.png" alt="" class="post-picture">

                                    <?= htmlspecialchars($user["name"], ENT_QUOTES, "UTF-8") ?>

                                    <button type="button" aria-label="Edit post" class="post-edit">✎</button>
                                </div>

                                <div class="post-content">


                                    <!-- Add post content or an image here -->


                                </div>
                            </article>

                            <article class="post-card">
                                <div class="post-heading">
                                    <img src="home1.png" alt="" class="post-picture">

                                    <?= htmlspecialchars($user["name"], ENT_QUOTES, "UTF-8") ?>

                                    <button type="button" aria-label="Edit post" class="post-edit">✎</button>
                                </div>

                                <div class="post-content">


                                    <!-- Add post content or an image here -->


                                </div>
                            </article>

                        </div>
                    </section>

                </div>

            </div>
        </section>

    </main>


    

    <script>
        const editBtn = document.getElementById("editProfileBtn");
        const editForm = document.getElementById("editProfileForm");
        const cancelBtn = document.getElementById("cancelEditBtn");

        editForm.style.display = "none";

        editBtn.addEventListener("click", function () {
            editForm.style.display = "block";
        });

        cancelBtn.addEventListener("click", function () {
            editForm.style.display = "none";
        });

        // Profile photo preview
        const photoInput = document.getElementById("photoInput");
        const profileImage = document.getElementById("profileImage");
        const editPhotoBtn = document.getElementById("editPhotoBtn");
        const uploadPhotoBtn = document.getElementById("uploadPhotoBtn");

        // Open the file picker
        editPhotoBtn.addEventListener("click", function () {
            photoInput.click();
        });

        // Preview the selected photo
        photoInput.addEventListener("change", function () {
            const file = this.files[0];

            if (file) {
                if (!["image/jpeg", "image/png", "image/webp"].includes(file.type)) {
                    alert("Please select a JPG, PNG, or WEBP image.");
                    this.value = "";
                    return;
                }

                // Show the selected photo preview
                profileImage.src = URL.createObjectURL(file);

                // Replace Edit Photo with Save Photo
                editPhotoBtn.hidden = true;
                uploadPhotoBtn.hidden = false;
            }
        });

        const notificationBell = document.getElementById("notificationBell");
        const notificationDropdown = document.getElementById("notificationDropdown");

        notificationBell.addEventListener("click", function () {

            const isHidden = notificationDropdown.hidden;

            notificationDropdown.hidden = !isHidden;

            notificationBell.setAttribute("aria-expanded", isHidden);

        });
    </script>

<?php require __DIR__ . "/includes/footer.php"; ?>
