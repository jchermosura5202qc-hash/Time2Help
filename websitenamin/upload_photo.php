<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: loginuser--signup.php");
    exit;
}

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: userprof.php");
    exit;
}

if (
    !isset($_FILES["profile_photo"]) ||
    $_FILES["profile_photo"]["error"] !== UPLOAD_ERR_OK
) {
    $_SESSION["photo_error"] = "Please select a photo to upload.";
    header("Location: userprof.php");
    exit;
}

$file = $_FILES["profile_photo"];

// Maximum file size: 2 MB
if ($file["size"] > 2 * 1024 * 1024) {
    $_SESSION["photo_error"] = "Your photo must be 2 MB or smaller.";
    header("Location: userprof.php");
    exit;
}

// Check the actual image type
$imageInfo = getimagesize($file["tmp_name"]);

if ($imageInfo === false) {
    $_SESSION["photo_error"] = "Please upload a valid image.";
    header("Location: userprof.php");
    exit;
}

$allowedTypes = [
    "image/jpeg" => "jpg",
    "image/png"  => "png",
    "image/webp" => "webp"
];

$mimeType = $imageInfo["mime"];

if (!isset($allowedTypes[$mimeType])) {
    $_SESSION["photo_error"] =
        "Only JPG, PNG, and WEBP images are allowed.";

    header("Location: userprof.php");
    exit;
}

// Create a unique filename
$extension = $allowedTypes[$mimeType];
$fileName = bin2hex(random_bytes(16)) . "." . $extension;

$uploadDirectory = __DIR__ . "/uploads/profile_photos/";
$photoPath = "uploads/profile_photos/" . $fileName;

// Make sure the upload directory exists
if (!is_dir($uploadDirectory)) {
    $_SESSION["photo_error"] = "The photo upload folder was not found.";
    header("Location: userprof.php");
    exit;
}

// Move the uploaded image into the folder
if (!move_uploaded_file(
    $file["tmp_name"],
    $uploadDirectory . $fileName
)) {
    $_SESSION["photo_error"] = "Unable to save your photo.";
    header("Location: userprof.php");
    exit;
}

try {
    $stmt = $pdo->prepare(
        "UPDATE users
         SET profile_photo = :photo
         WHERE id = :id"
    );

    $stmt->execute([
        ":photo" => $photoPath,
        ":id" => $_SESSION["user_id"]
    ]);

    $_SESSION["photo_success"] = "Profile photo updated successfully!";

    header("Location: userprof.php");
    exit;

} catch (PDOException $e) {
    // Remove the uploaded file if the database update fails
    if (file_exists($uploadDirectory . $fileName)) {
        unlink($uploadDirectory . $fileName);
    }

    error_log($e->getMessage());

    $_SESSION["photo_error"] = "Unable to update your profile photo.";
    header("Location: userprof.php");
    exit;
}
?>