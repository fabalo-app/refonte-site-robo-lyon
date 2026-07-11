<?php
require_once __DIR__ . '/includes/bootstrap.php';

if (is_logged_in()) {
    header('Location: admin.php');
    exit;
}

$adminCount = (int) db()->query('SELECT COUNT(*) c FROM admins')->fetch()['c'];
$isSetup = $adminCount === 0;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($isSetup) {
        $confirm = (string)($_POST['password_confirm'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Adresse e-mail invalide.";
        } elseif (strlen($password) < 8) {
            $error = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif ($password !== $confirm) {
            $error = "Les mots de passe ne correspondent pas.";
        } else {
            $recheck = (int) db()->query('SELECT COUNT(*) c FROM admins')->fetch()['c'];
            if ($recheck > 0) {
                $error = "Un compte administrateur existe déjà, veuillez vous connecter.";
                $isSetup = false;
            } else {
                $stmt = db()->prepare('INSERT INTO admins (email, password_hash, role) VALUES (?, ?, ?)');
                $stmt->execute([$email, password_hash($password, PASSWORD_DEFAULT), 'owner']);
                session_regenerate_id(true);
                $_SESSION['admin_id'] = db()->lastInsertId();
                $_SESSION['edit_mode'] = true;
                header('Location: admin.php');
                exit;
            }
        }
    } else {
        $attempts = db()->prepare('SELECT COUNT(*) c FROM login_attempts WHERE email = ? AND attempted_at > (NOW() - INTERVAL 15 MINUTE)');
        $attempts->execute([$email]);
        if ((int)$attempts->fetch()['c'] >= 8) {
            $error = "Trop de tentatives. Réessayez dans quelques minutes.";
        } else {
            $stmt = db()->prepare('SELECT id, password_hash FROM admins WHERE email = ?');
            $stmt->execute([$email]);
            $row = $stmt->fetch();
            if ($row && password_verify($password, $row['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $row['id'];
                header('Location: admin.php');
                exit;
            }
            $log = db()->prepare('INSERT INTO login_attempts (email) VALUES (?)');
            $log->execute([$email]);
            $error = "E-mail ou mot de passe incorrect.";
            usleep(400000);
        }
    }
}

$pageTitle = "Connexion — Robo'Lyon";
require __DIR__ . '/includes/partials/head.php';
?>
<div style="min-height:100vh; display:flex; align-items:center; justify-content:center; background:#F5F5F7; padding:24px;">
  <div style="background:#fff; border-radius:16px; padding:36px; max-width:380px; width:100%; box-shadow:0 20px 44px rgba(11,31,58,0.1);">
    <div style="display:flex; align-items:center; gap:9px; margin-bottom:24px;">
      <img src="assets/img/brand/logo-robolyon-blue.svg" alt="Logo Robo'Lyon" style="height:22px;">
      <span style="font-weight:600; font-size:14.5px; color:#1D1D1F;">Robo'Lyon</span>
    </div>
    <?php if ($isSetup): ?>
      <h1 style="font-weight:700; font-size:19px; margin:0 0 6px;">Créer le compte administrateur</h1>
      <p style="color:#6E6E73; font-size:13.5px; margin:0 0 24px;">Aucun administrateur n'existe encore. Créez le premier compte (propriétaire) pour pouvoir gérer le site.</p>
    <?php else: ?>
      <h1 style="font-weight:700; font-size:19px; margin:0 0 24px;">Connexion admin</h1>
    <?php endif; ?>
    <?php if ($error): ?><div style="background:#FCE8E8; color:#D62828; font-size:13px; font-weight:600; padding:10px 14px; border-radius:8px; margin-bottom:16px;"><?= h($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
      <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">E-mail</label>
      <input type="email" name="email" required value="<?= h($_POST['email'] ?? '') ?>" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:14px;">
      <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Mot de passe</label>
      <input type="password" name="password" required minlength="8" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:14px;">
      <?php if ($isSetup): ?>
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" required minlength="8" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:20px;">
      <?php endif; ?>
      <button type="submit" style="width:100%; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px; border:none; border-radius:980px; cursor:pointer; margin-top:6px;"><?= $isSetup ? 'Créer le compte' : 'Se connecter' ?></button>
    </form>
    <div style="text-align:center; margin-top:18px;"><a href="index.php" style="font-size:13px; color:#6E6E73;">← Retour au site</a></div>
  </div>
</div>
<?php require __DIR__ . '/includes/partials/footer_minimal.php'; ?>
