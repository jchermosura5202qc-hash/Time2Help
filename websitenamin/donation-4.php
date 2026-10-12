<?php
// Volunteer registration
$tab = 'volunteer';
$active = 'donate';
$pageTitle = 'Volunteer';
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = clean('fullname');
    $email = clean('email');
    $phone = clean('phone');

    if ($name === '') $errors['fullname'] = 'Enter your full name.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
    if ($phone === '' || !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) $errors['phone'] = 'Enter a valid phone number.';

    if (!$errors) {
        // TODO: save the volunteer to your database here.
        $success = true;
    }
}

// Page-specific CSS (printed in <head> by includes/header.php)
$pageCss = ['donation.css'];
$bodyBg = '#F1EBD8';
$inlineCss = <<<'CSS'
.card{max-width:780px;margin:0 auto;background:#e9e3cd;border-radius:6px;overflow:hidden;display:grid;grid-template-columns:1fr 1fr;box-shadow:0 8px 30px rgba(0,0,0,.25)}
.card-photo{min-height:360px;color:#fff;display:flex;flex-direction:column;justify-content:center;gap:6px;padding:18px;background:linear-gradient(180deg,rgba(20,40,50,.1),rgba(20,40,50,.85)),linear-gradient(160deg,#6b8f9a,#2c4a55 65%,#c3b48d 66%,#8c7b55)}
.earth-title{font-family:var(--serif);font-weight:700;font-size:1.6rem;line-height:1.15;margin:0 0 10px;text-align:center}
.photo-sub{font-size:.7rem;text-align:center;margin:0;opacity:.95}

.card-form{font-size:.8rem;display:flex;flex-direction:column;gap:6px;padding:28px 30px;justify-content:center}
.card-form h1{font-family:var(--serif);font-size:1.5rem;text-align:center;margin:0 0 10px}
.label{font-weight:600;font-size:.78rem;margin-top:8px;display:block}
.card-form input{font:inherit;width:100%;background:#eef0dc;border:1.5px solid var(--green-800);border-radius:6px;padding:8px 10px}
.invalid{border-color:var(--err)!important;outline:1px solid var(--err)}
.field-error{color:var(--err);margin:0;font-size:.72rem}
.notice{padding:8px 10px;border-radius:4px;font-weight:500}
.notice.ok{background:#dfeab0}
.notice.err{background:#f4d4cc;color:var(--err)}

.actions{display:flex;justify-content:center;margin-top:18px}
.btn{font:inherit;font-weight:600;padding:8px 18px;border-radius:4px;border:1px solid rgba(0,0,0,.2);cursor:pointer;background:var(--green-800);color:#fff}
.btn:hover{background:var(--green-900)}

@media (max-width:820px){
  .card{grid-template-columns:1fr}
  .card-photo{min-height:220px}
}
CSS;

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/donation-tabs.php';
?>
<main class="stage stage-plain">
  <section class="card card-volunteer" aria-labelledby="reg-title">
    <div class="card-photo photo-earth">
      <p class="earth-title">Work for<br>the Earth</p>
      <p class="photo-sub">Together with passions across the globe, we're tackling the issue of ocean cleaning up. Be part of the largest environmental volunteer event in history.</p>
    </div>

    <form class="card-form form-volunteer" method="post" novalidate>
      <h1 id="reg-title">Register Here</h1>

      <?php if ($success): ?>
        <div class="notice ok" role="status">Thanks, <?= e($name) ?>! You're registered. We'll email you the details.</div>
      <?php elseif ($errors): ?>
        <div class="notice err" role="alert">Please fix the highlighted fields.</div>
      <?php endif; ?>

      <label class="label" for="fullname">Full Name</label>
      <input id="fullname" type="text" name="fullname" placeholder="Enter Full Name" value="<?= old('fullname') ?>" class="<?= isset($errors['fullname']) ? 'invalid' : '' ?>">
      <?php if (isset($errors['fullname'])): ?><p class="field-error"><?= e($errors['fullname']) ?></p><?php endif; ?>

      <label class="label" for="email">Email</label>
      <input id="email" type="email" name="email" placeholder="Enter Email" value="<?= old('email') ?>" class="<?= isset($errors['email']) ? 'invalid' : '' ?>">
      <?php if (isset($errors['email'])): ?><p class="field-error"><?= e($errors['email']) ?></p><?php endif; ?>

      <label class="label" for="phone">Phone Number</label>
      <input id="phone" type="tel" name="phone" placeholder="Enter Phone Number" value="<?= old('phone') ?>" class="<?= isset($errors['phone']) ? 'invalid' : '' ?>">
      <?php if (isset($errors['phone'])): ?><p class="field-error"><?= e($errors['phone']) ?></p><?php endif; ?>

      <div class="actions center">
        <button type="submit" class="btn btn-primary">Be A Volunteer!</button>
      </div>
    </form>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
