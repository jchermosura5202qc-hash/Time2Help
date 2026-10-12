<?php
$pageTitle = "Leaderboard";
$pageCss = ["leaderboard.css"];
$active = "leaderboard";
$bodyBg = "#f3ecd8";
require __DIR__ . "/includes/header.php";

/* Logged-in member gets the lime row (falls back to the demo name) */
$currentUser = $sideUser['name'] ?? 'Batumbakal';

/* ============================================================
   TIME2HELP — Leaderboard
   Data is kept in a PHP array for now. When your database is
   ready, replace loadPlayers() with a query (highest points first).
   ============================================================ */


/* ---------- Data layer (swap for DB later) ---------- */
function loadPlayers(): array {
    $players = [
        ['name' => 'Lawrence Labanza', 'points' => 600],
        ['name' => 'John Doe',         'points' => 520],
        ['name' => 'Jane Smith',       'points' => 450],
        ['name' => 'Bob Johnson',      'points' => 400],
        ['name' => 'Alice Williams',   'points' => 367],
        ['name' => 'Batumbakal',       'points' => 340],
        ['name' => 'Charlie Brown',    'points' => 320],
        ['name' => 'Diana Miller',     'points' => 318],
        ['name' => 'Eve Davis',        'points' => 310],
        ['name' => 'Frank Wilson',     'points' => 290],
    ];
    // Highest points first
    usort($players, fn($a, $b) => $b['points'] <=> $a['points']);
    return $players;
}

/* ---------- Helpers ---------- */
function e(?string $v): string {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

/* Medal icon: ring colour + ribbon colour per place */
function medal(int $place): string {
    $colors = [
        1 => ['ring' => '#e6b422', 'inner' => '#f6d55c', 'ribbon' => '#c0392b'],
        2 => ['ring' => '#9aa7b8', 'inner' => '#d5dde8', 'ribbon' => '#2e6fb5'],
        3 => ['ring' => '#b9772f', 'inner' => '#e0a96b', 'ribbon' => '#7a3fa0'],
    ];
    $c = $colors[$place];
    return <<<SVG
<svg viewBox="0 0 30 36" aria-hidden="true">
  <path d="M8 18 L4 34 L11 30 L15 35 L15 18Z" fill="{$c['ribbon']}"/>
  <path d="M22 18 L26 34 L19 30 L15 35 L15 18Z" fill="{$c['ribbon']}" opacity=".85"/>
  <circle cx="15" cy="12" r="11" fill="{$c['ring']}"/>
  <circle cx="15" cy="12" r="8" fill="{$c['inner']}"/>
  <path d="M15 6.500l1.700 3.500 3.800.5-2.800 2.600.7 3.800L15 15.200l-3.400 1.700.7-3.800-2.800-2.600 3.800-.5z" fill="{$c['ring']}"/>
</svg>
SVG;
}

$players = loadPlayers();

/* Top 3 are shown in the order 2nd, 1st, 3rd (like the mockup) */
$podium = [];
foreach ([2, 1, 3] as $place) {
    if (isset($players[$place - 1])) {
        $podium[] = ['place' => $place] + $players[$place - 1];
    }
}

/* Rank 4 and below */
$rest = array_slice($players, 3);
?>

<!-- ===== MAIN ===== -->
  <main class="lb-main">
    <section class="board">
      <div class="board-head">
        <h1>See where you are!</h1>
        <p>Here is your Leaderboard</p>
      </div>

      <div class="board-body">
        <!-- Top 3 (order is 2nd, 1st, 3rd) -->
        <div class="podium">
          <?php foreach ($podium as $p): ?>
            <div class="podium-card<?= $p['place'] === 1 ? ' first' : '' ?>">
              <?= medal($p['place']) ?>
              <span><?= e($p['name']) ?></span>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="table-head">
          <span>Members</span>
          <span>Rank</span>
          <span>POINTS</span>
        </div>

        <ul class="rows">
          <?php if (!$rest): ?>
            <li class="empty">No other members yet.</li>
          <?php else: foreach ($rest as $i => $p): ?>
            <li class="row<?= $p['name'] === $currentUser ? ' me' : '' ?>">
              <span><?= e($p['name']) ?></span>
              <span><?= $i + 4 ?></span>
              <span><?= (int)$p['points'] ?></span>
            </li>
          <?php endforeach; endif; ?>
        </ul>
      </div>
    </section>
  </main>

<?php require __DIR__ . "/includes/footer.php"; ?>
