<?php
session_start();
require_once __DIR__ . '/config.php';

if (!$REQUIRE_PASSWORD) { return; }

if (isset($_POST['passcode'])) {
  if (hash_equals($RESULTS_PASSCODE, $_POST['passcode'])) {
    $_SESSION['results_auth'] = 1;
    header('Location: index.php'); exit;
  } else { $error = 'Incorrect passcode.'; }
}

if (!isset($_SESSION['results_auth'])): ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Results Access</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card{max-width:420px;margin:12vh auto;border-radius:16px;box-shadow:0 6px 20px rgba(0,0,0,.06)}
    .btn-red{background:#ff3131;border:2px solid #ff3131;color:#fff;font-weight:700}
    .btn-red:hover{background:#fff;color:#ff3131}
    .logo{height:120px;display:block;margin:10px auto 6px}
  </style>
</head>
<body>
  <img src="../logo.png" class="logo" onerror="this.src='logo.png';" alt="Logo">
  <div class="card p-4">
    <h4 class="text-center fw-bold mb-3">Enter Passcode</h4>
    <?php if (!empty($error)): ?><div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label class="form-label">Passcode</label><input type="password" name="passcode" class="form-control form-control-lg" required></div>
      <button class="btn btn-red w-100">Continue</button>
    </form>
  </div>
</body>
</html>
<?php exit; endif;
