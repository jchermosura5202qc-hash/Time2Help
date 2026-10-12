<?php /* Sub-navigation shared by the three donation pages. Set $tab = cash|kind|volunteer before including. */ ?>
    <div class="tabs-bar">
        <nav class="tabs" aria-label="Ways to help">
            <a href="donation-1.php" class="<?= ($tab ?? '') === 'cash' ? 'active' : '' ?>">Donation in Cash</a>
            <a href="donation-3.php" class="<?= ($tab ?? '') === 'kind' ? 'active' : '' ?>">Donation in kind</a>
            <a href="donation-4.php" class="<?= ($tab ?? '') === 'volunteer' ? 'active' : '' ?>">Volunteer</a>
        </nav>
    </div>
