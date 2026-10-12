<?php
/**
 * Shared header for every TIME2HELP page.
 *
 * Set these BEFORE requiring this file (all optional):
 *   $pageTitle  string   -> <title>
 *   $pageCss    array    -> extra stylesheets, e.g. ["news.css"]
 *   $inlineCss  string   -> page-specific CSS printed in a <style> tag
 *   $bodyBg     string   -> body background colour (default #F2EBD8)
 *   $active     string   -> highlights the matching nav link
 *                           (home|leaderboard|news|about|donate)
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = $pageTitle ?? "TIME2HELP";
$pageCss   = $pageCss   ?? [];
$bodyBg    = $bodyBg    ?? "#F2EBD8";
$active    = $active    ?? "";
$inlineCss = $inlineCss ?? "";

// Logged-in user (used by the side menu)
// (own variable so it never clobbers a page's own $user)
// Only touches the database when someone is logged in, and never stops the
// page if the database is down (the side menu just shows "USER").
$sideUser = null;
if (isset($_SESSION["user_id"])) {
    try {
        if (!isset($pdo)) {
            $pdo = new PDO(
                "mysql:host=localhost;dbname=time2help_db;charset=utf8mb4",
                "root",
                "",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
        }
        $stmt = $pdo->prepare("SELECT name, atype, profile_photo FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([":id" => $_SESSION["user_id"]]);
        $sideUser = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
}

$navItems = [
    "home"        => ["home.php",        "HOME"],
    "leaderboard" => ["leaderboard.php", "LEADERBOARD"],
    "news"        => ["news.php",        "NEWS"],
    "about"       => ["aboutus.php",     "ABOUT US"],
    "donate"      => ["donation-1.php",  "DONATE"],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | TIME2HELP</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="sidebar.css">
<?php foreach ($pageCss as $css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
<?php endforeach; ?>
<?php if ($inlineCss !== ""): ?>
    <style>
<?= $inlineCss ?>
    </style>
<?php endif; ?>
</head>

<body<?= $bodyBg !== "" ? ' style="background-color: ' . htmlspecialchars($bodyBg) . ';"' : "" ?>>

    <header class="header">

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="logo" id="home">
            <a href="home.php" style="color:inherit;text-decoration:none;"><h1>TIME2HELP</h1></a>
        </div>

        <nav class="nav">
            <ul>
<?php foreach ($navItems as $key => [$href, $label]): ?>
                <li><a href="<?= $href ?>"<?= $active === $key ? ' style="color:#D2D69C;text-decoration:underline;"' : '' ?>><?= $label ?></a></li>
<?php endforeach; ?>
            </ul>
        </nav>

    </header>

    <div class="menu-overlay"></div>

    <aside class="side-menu">

        <div class="menu-profile">
            <button class="close-menu" aria-label="Close menu">&larr;</button>

            <img src="<?= !empty($sideUser['profile_photo']) ? htmlspecialchars($sideUser['profile_photo']) : 'home1.png' ?>" alt="Profile Picture">

            <h3><?= htmlspecialchars($sideUser['name'] ?? 'USER') ?></h3>

            <p><?= !empty($sideUser['atype']) ? htmlspecialchars($sideUser['atype']) : 'USER' ?></p>
        </div>

        <div class="menu-box">
            <div class="menu-links">
                <a href="userprof.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="#395442" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" />
                        <circle cx="12" cy="9" r="3" />
                        <path d="M6.5 19c.6-3.1 2.5-4.5 5.5-4.5s4.9 1.4 5.5 4.5" />
                    </svg>
                    <strong>PROFILE</strong></a>

                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#395442"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path d="M16 3v4M8 3v4M3 10h18M7 14h2M12 14h2M7 17h2" />
                    </svg><strong>SCHEDULE</strong></a>

                <a href="requesters-post.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#395442"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 10.5 12 3l9 7.5V21H3z" />
                        <path d="M9 21v-6h6v6" />
                        <path d="M12 13s-3-1.7-3-3.5a1.8 1.8 0 0 1 3-1.2 1.8 1.8 0 0 1 3 1.2C15 11.3 12 13 12 13z" />
                    </svg><strong>REQUEST POSTS</strong></a>

<?php if (!isset($_SESSION["user_id"])): ?>
                <a href="loginuser--signup.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="#395442" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 3h-8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                        <path d="M10 12h11M16 7l5 5-5 5" />
                    </svg><strong>LOG IN / SIGN UP</strong></a>
<?php else: ?>
                <a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                        stroke="#395442" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 3h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-8" />
                        <path d="M14 12H3M8 7l-5 5 5 5" />
                    </svg><strong>LOG OUT</strong></a>
<?php endif; ?>

                <a href="feedback.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#395442"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H6l-3 2v-6.5A7.5 7.5 0 1 1 20 11.5z" />
                        <path d="m10 13 5-5 2 2-5 5-3 1z" />
                    </svg><strong>FEEDBACK</strong></a>
            </div>
        </div>

    </aside>
