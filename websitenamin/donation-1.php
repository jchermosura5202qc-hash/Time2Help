<?php
// Donation in Cash
$tab = 'cash';
$active = 'donate';
$pageTitle = 'Donation in Cash';
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$success = false;
$amounts = ['25', '50', '100'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $org       = clean('organization');
    $amount    = clean('amount');
    $anonymous = isset($_POST['anonymous']);
    $name      = clean('name');
    $address   = clean('address');
    $email     = clean('email');
    $phone     = clean('phone');

    if (!in_array($org, $ORGANIZATIONS, true)) $errors['organization'] = 'Choose an organization.';
    if (!in_array($amount, $amounts, true))    $errors['amount'] = 'Choose a donation amount.';
    if (!$anonymous) {
        if ($name === '') $errors['name'] = 'Enter your name, or choose to remain anonymous.';
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email address.';
        if ($phone !== '' && !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) $errors['phone'] = 'Enter a valid phone number.';
    }

    if (!$errors) {
        // TODO: save to your database or payment gateway here.
        $success = true;
    }
}

// Page-specific CSS (printed in <head> by includes/header.php)
$pageCss = ['donation.css'];
$bodyBg = '#F1EBD8';
$inlineCss = <<<'CSS'
.stage{background:#8a968d}
.card{max-width:780px;margin:0 auto;background:var(--cream);border-radius:14px;padding:18px;display:grid;grid-template-columns:5fr 6fr;gap:22px;box-shadow:0 8px 30px rgba(0,0,0,.25)}
.card-photo{border-radius:8px;min-height:420px;overflow:hidden;color:#fff;display:flex;flex-direction:column;justify-content:flex-end;padding:18px}
.photo-future{background:linear-gradient(180deg,rgba(40,70,70,.25),rgba(30,55,55,.85)),radial-gradient(circle at 30% 30%,#7fa0a0,#2f5555 70%)}
.photo-caption{font-family:var(--serif);font-weight:700;font-size:2rem;line-height:1.1;margin:0}

.card-form{font-size:.8rem;display:flex;flex-direction:column;gap:6px}
.intro{margin:0 0 6px;font-size:.75rem}
.label{font-weight:600;font-size:.78rem;margin-top:8px;display:block;padding:0}
fieldset{border:0;margin:0;padding:0;display:flex;flex-direction:column;gap:4px}
legend{padding:0;margin-top:8px}
select,.card-form input[type=text],.card-form input[type=email],.card-form input[type=tel]{font:inherit;width:100%;padding:6px 8px;border:1px solid #9aa58f;border-radius:4px;background:#fff}
.radio{display:flex;align-items:center;gap:8px;cursor:pointer}
.radio input,.anon input{accent-color:var(--green-800)}
.anon{display:flex;align-items:center;gap:8px;background:var(--lime);padding:5px 8px;border-radius:4px;font-weight:500;cursor:pointer}
.info-box{background:#fff;border:1px solid #cfcab5;border-radius:4px;padding:10px;display:flex;flex-direction:column;gap:6px}
.info-box label{display:flex;align-items:center;gap:6px;font-size:.75rem}
.info-box input{border:0!important;border-bottom:1px solid #777!important;border-radius:0!important;padding:2px 4px!important;background:transparent!important}
.invalid{border-color:var(--err)!important;outline:1px solid var(--err)}
.field-error{color:var(--err);margin:0;font-size:.72rem}
.notice{padding:8px 10px;border-radius:4px;font-weight:500}
.notice.ok{background:#dfeab0}
.notice.err{background:#f4d4cc;color:var(--err)}

.actions{display:flex;justify-content:flex-end;gap:10px;margin-top:10px}
.btn{font:inherit;font-weight:600;padding:8px 18px;border-radius:4px;border:1px solid rgba(0,0,0,.2);text-decoration:none;cursor:pointer;display:inline-block}
.btn-primary{background:var(--lime);color:var(--ink)}
.btn-primary:hover{background:#b8d03a}
.btn-ghost{background:transparent;color:#7d8a5a;border-color:#c6cca8}

@media (max-width:820px){
  .card{grid-template-columns:1fr}
  .card-photo{min-height:220px}
}
CSS;

require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/donation-tabs.php';
?>
<main class="stage">
  <section class="card" aria-labelledby="form-title">
    <div class="card-photo photo-future">
      <p class="photo-caption">We Can<br>Save The<br>Future</p>
    </div>

    <form class="card-form" method="post" novalidate>
      <p id="form-title" class="intro">Welcome to TIME2HELP donation, please fill the form below. Hopefully it is cleared.</p>

      <?php if ($success): ?>
        <div class="notice ok" role="status">Thank you<?= $anonymous || $name === '' ? '' : ', ' . e($name) ?>! Your $<?= e($amount) ?> donation was received.</div>
      <?php elseif ($errors): ?>
        <div class="notice err" role="alert">Please fix the highlighted fields.</div>
      <?php endif; ?>

      <label class="label" for="organization">Choose an Organization:</label>
      <select id="organization" name="organization" class="<?= isset($errors['organization']) ? 'invalid' : '' ?>">
        <?php foreach ($ORGANIZATIONS as $o): ?>
          <option value="<?= e($o) ?>" <?= selected('organization', $o) ?>><?= e($o) ?></option>
        <?php endforeach; ?>
      </select>
      <?php if (isset($errors['organization'])): ?><p class="field-error"><?= e($errors['organization']) ?></p><?php endif; ?>

      <fieldset>
        <legend class="label">Choose a donation amount:</legend>
        <?php foreach ($amounts as $a): ?>
          <label class="radio"><input type="radio" name="amount" value="<?= $a ?>" <?= checked('amount', $a) ?>> $<?= $a ?></label>
        <?php endforeach; ?>
        <?php if (isset($errors['amount'])): ?><p class="field-error"><?= e($errors['amount']) ?></p><?php endif; ?>
      </fieldset>

      <p class="label">Donation Information:</p>
      <label class="anon"><input type="checkbox" name="anonymous" <?= isset($_POST['anonymous']) ? 'checked' : '' ?>> Remain Anonymous?</label>

      <div class="info-box">
        <label>Name: <input type="text" name="name" value="<?= old('name') ?>" class="<?= isset($errors['name']) ? 'invalid' : '' ?>"></label>
        <?php if (isset($errors['name'])): ?><p class="field-error"><?= e($errors['name']) ?></p><?php endif; ?>
        <label>Address: <input type="text" name="address" value="<?= old('address') ?>"></label>
        <label>Email Address: <input type="email" name="email" value="<?= old('email') ?>" class="<?= isset($errors['email']) ? 'invalid' : '' ?>"></label>
        <?php if (isset($errors['email'])): ?><p class="field-error"><?= e($errors['email']) ?></p><?php endif; ?>
        <label>Phone Number: <input type="tel" name="phone" value="<?= old('phone') ?>" class="<?= isset($errors['phone']) ? 'invalid' : '' ?>"></label>
        <?php if (isset($errors['phone'])): ?><p class="field-error"><?= e($errors['phone']) ?></p><?php endif; ?>
      </div>

      <div class="actions">
        <a href="donation-1.php" class="btn btn-ghost">Cancel</a>
        <button type="submit" class="btn btn-primary">Confirm Donation</button>
      </div>
    </form>
  </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
