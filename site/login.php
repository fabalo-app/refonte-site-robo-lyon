<?php
require_once __DIR__ . '/includes/bootstrap.php';

if (is_logged_in()) {
    header('Location: admin.php');
    exit;
}

$adminCount = (int) db()->query('SELECT COUNT(*) c FROM admins')->fetch()['c'];
$isSetup = $adminCount === 0;
$error = null;
$email = trim((string)($_POST['email'] ?? $_GET['email'] ?? ''));

function login_lookup_admin(string $email): ?array {
    if ($email === '') return null;
    $stmt = db()->prepare('SELECT id, password_hash FROM admins WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetch() ?: null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
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
                $stmt = db()->prepare('INSERT INTO admins (email, password_hash, role, title) VALUES (?, ?, ?, ?)');
                $stmt->execute([$email, password_hash($password, PASSWORD_DEFAULT), 'owner', 'Propriétaire']);
                session_regenerate_id(true);
                $_SESSION['admin_id'] = db()->lastInsertId();
                $_SESSION['edit_mode'] = true;
                header('Location: admin.php');
                exit;
            }
        }
    } elseif (($_POST['step'] ?? '') === 'activate') {
        // Première connexion d'un administrateur invité : il choisit lui-même son mot de passe,
        // aucun mot de passe temporaire n'a été généré ni communiqué (voir api/admins-add.php).
        $admin = login_lookup_admin($email);
        $confirm = (string)($_POST['password_confirm'] ?? '');
        if (!$admin || $admin['password_hash'] !== null) {
            $error = "Ce compte est déjà activé, connectez-vous avec votre mot de passe.";
        } elseif (strlen($password) < 8) {
            $error = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif ($password !== $confirm) {
            $error = "Les mots de passe ne correspondent pas.";
        } else {
            $upd = db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?');
            $upd->execute([password_hash($password, PASSWORD_DEFAULT), $admin['id']]);
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: admin.php');
            exit;
        }
    } elseif (($_POST['step'] ?? '') === 'password') {
        $admin = login_lookup_admin($email);
        $attempts = db()->prepare('SELECT COUNT(*) c FROM login_attempts WHERE email = ? AND attempted_at > (NOW() - INTERVAL 15 MINUTE)');
        $attempts->execute([$email]);
        if ((int)$attempts->fetch()['c'] >= 8) {
            $error = "Trop de tentatives. Réessayez dans quelques minutes.";
        } elseif ($admin && $admin['password_hash'] !== null && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: admin.php');
            exit;
        } else {
            $log = db()->prepare('INSERT INTO login_attempts (email) VALUES (?)');
            $log->execute([$email]);
            $error = "E-mail ou mot de passe incorrect.";
            usleep(400000);
        }
    }
}

// Détermine l'étape à afficher, une fois un éventuel POST ci-dessus traité.
$admin = $isSetup ? null : login_lookup_admin($email);
$needsActivation = $admin !== null && $admin['password_hash'] === null;
if ($isSetup) {
    $step = 'setup';
} elseif ($email === '') {
    $step = 'email';
} elseif ($needsActivation) {
    $step = 'activate';
} else {
    $step = 'password';
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

    <?php if ($step === 'setup'): ?>
      <h1 style="font-weight:700; font-size:19px; margin:0 0 6px;">Créer le compte administrateur</h1>
      <p style="color:#6E6E73; font-size:13.5px; margin:0 0 24px;">Aucun administrateur n'existe encore. Créez le premier compte (propriétaire) pour pouvoir gérer le site.</p>
    <?php elseif ($step === 'activate'): ?>
      <h1 style="font-weight:700; font-size:19px; margin:0 0 6px;">Choisissez votre mot de passe</h1>
      <p style="color:#6E6E73; font-size:13.5px; margin:0 0 24px;">Première connexion avec <strong><?= h($email) ?></strong> — choisissez le mot de passe que vous utiliserez désormais.</p>
    <?php elseif ($step === 'password'): ?>
      <h1 style="font-weight:700; font-size:19px; margin:0 0 6px;">Se connecter</h1>
      <p style="color:#6E6E73; font-size:13.5px; margin:0 0 24px;"><?= h($email) ?> — <a href="login.php" style="color:#6E6E73;">changer d'e-mail</a></p>
    <?php else: ?>
      <h1 style="font-weight:700; font-size:19px; margin:0 0 24px;">Se connecter</h1>
    <?php endif; ?>

    <?php if ($error): ?><div style="background:#FCE8E8; color:#D62828; font-size:13px; font-weight:600; padding:10px 14px; border-radius:8px; margin-bottom:16px;"><?= h($error) ?></div><?php endif; ?>

    <?php if ($step === 'email'): ?>
      <form method="get">
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">E-mail</label>
        <input type="email" name="email" required autofocus style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:20px;">
        <button type="submit" style="width:100%; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px; border:none; border-radius:980px; cursor:pointer;">Continuer</button>
      </form>
    <?php elseif ($step === 'setup'): ?>
      <form method="post">
        <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">E-mail</label>
        <input type="email" name="email" required value="<?= h($email) ?>" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:14px;">
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Mot de passe</label>
        <input type="password" name="password" required minlength="8" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:14px;">
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" required minlength="8" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:20px;">
        <button type="submit" style="width:100%; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px; border:none; border-radius:980px; cursor:pointer;">Créer le compte</button>
      </form>
    <?php elseif ($step === 'activate'): ?>
      <form method="post">
        <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
        <input type="hidden" name="step" value="activate">
        <input type="hidden" name="email" value="<?= h($email) ?>">
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Nouveau mot de passe</label>
        <input type="password" name="password" required minlength="8" autofocus style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:14px;">
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" required minlength="8" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:20px;">
        <button type="submit" style="width:100%; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px; border:none; border-radius:980px; cursor:pointer;">Créer mon mot de passe</button>
      </form>
    <?php else: ?>
      <form method="post">
        <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
        <input type="hidden" name="step" value="password">
        <input type="hidden" name="email" value="<?= h($email) ?>">
        <label style="display:block; font-weight:600; font-size:13px; margin-bottom:6px;">Mot de passe</label>
        <input type="password" name="password" required minlength="8" autofocus style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:14.5px; margin-bottom:20px;">
        <button type="submit" style="width:100%; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px; border:none; border-radius:980px; cursor:pointer;">Se connecter</button>
      </form>
    <?php endif; ?>

    <div style="text-align:center; margin-top:18px;"><a href="index.php" style="font-size:13px; color:#6E6E73;">← Retour au site</a></div>
  </div>
</div>
<?php require __DIR__ . '/includes/partials/footer_minimal.php'; ?>
