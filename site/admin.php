<?php
require_once __DIR__ . '/includes/bootstrap.php';
$me = require_login();

$admins = db()->query('SELECT * FROM admins ORDER BY (role="owner") DESC, created_at')->fetchAll();
$sponsorCount = (int) db()->query('SELECT COUNT(*) c FROM sponsors')->fetch()['c'];
$actusCount = (int) db()->query('SELECT COUNT(*) c FROM actus')->fetch()['c'];
$teamsCount = (int) db()->query('SELECT COUNT(*) c FROM teams')->fetch()['c'];
$mentorsCount = (int) db()->query('SELECT COUNT(*) c FROM mentors')->fetch()['c'];

$pageTitle = "Espace admin — Robo'Lyon";
require __DIR__ . '/includes/partials/head.php';
?>
<div class="rl-stack-mobile" style="font-family:'Inter',-apple-system,sans-serif; color:#1D1D1F; display:flex; min-height:100vh; background:#F5F5F7;">

  <aside style="width:230px; flex-shrink:0; background:#0B1F3A; color:#A9B6D6; padding:26px 18px; display:flex; flex-direction:column; gap:6px;">
    <div style="display:flex; align-items:center; gap:9px; padding:0 10px 22px;">
      <img src="assets/img/brand/logo-robolyon-blue.svg" alt="Logo Robo'Lyon" style="height:20px; filter:brightness(0) invert(1);">
      <span style="font-weight:600; font-size:14px; color:#fff;">Robo'Lyon</span>
    </div>
    <div style="font-size:11px; font-weight:700; letter-spacing:0.05em; color:#6E85B8; padding:10px 12px 6px;">ESPACE ADMIN</div>
    <a href="admin.php" style="padding:10px 12px; border-radius:8px; font-weight:600; font-size:13.5px; color:#fff; background:#D62828;">Administrateurs</a>
    <a href="index.php" style="padding:10px 12px; border-radius:8px; font-weight:600; font-size:13px; color:#8FA0C4;">Voir le site</a>
    <a href="logout.php" style="padding:10px 12px; border-radius:8px; font-weight:600; font-size:13px; color:#8FA0C4;">Déconnexion</a>
    <div style="flex:1;"></div>
    <a href="index.php" style="padding:10px 12px; border-radius:8px; font-weight:600; font-size:13px; color:#8FA0C4;">← Retour au site</a>
  </aside>

  <main style="flex:1; padding:36px 44px; max-width:980px;">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:30px; flex-wrap:wrap; gap:12px;">
      <div>
        <h1 style="font-weight:700; font-size:24px; margin:0 0 6px; letter-spacing:-0.01em;">Administrateurs</h1>
        <p style="color:#6E6E73; font-size:14px; margin:0;">Gérez qui peut modifier les textes, images, actualités et sponsors du site.</p>
      </div>
      <div style="background:#fff; border:1px solid #D2D2D7; border-radius:980px; padding:8px 16px; font-size:13px; font-weight:600; display:flex; align-items:center; gap:8px;">
        <span style="width:8px; height:8px; border-radius:50%; background:#1BA34A; display:inline-block;"></span>
        Connecté : <?= h($me['email']) ?>
      </div>
    </div>

    <div class="rl-g5" style="grid-template-columns:repeat(5,1fr); gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden; margin-bottom:32px;">
      <div style="background:#fff; padding:20px;"><div style="font-weight:700; font-size:22px;"><?= count($admins) ?></div><div style="font-size:12.5px; color:#6E6E73; margin-top:4px;">Administrateurs</div></div>
      <div style="background:#fff; padding:20px;"><div style="font-weight:700; font-size:22px;"><?= $sponsorCount ?></div><div style="font-size:12.5px; color:#6E6E73; margin-top:4px;">Sponsors publiés</div></div>
      <div style="background:#fff; padding:20px;"><div style="font-weight:700; font-size:22px;"><?= $actusCount ?></div><div style="font-size:12.5px; color:#6E6E73; margin-top:4px;">Actualités publiées</div></div>
      <div style="background:#fff; padding:20px;"><div style="font-weight:700; font-size:22px;"><?= $teamsCount ?></div><div style="font-size:12.5px; color:#6E6E73; margin-top:4px;">Équipes</div></div>
      <div style="background:#fff; padding:20px;"><div style="font-weight:700; font-size:22px;"><?= $mentorsCount ?></div><div style="font-size:12.5px; color:#6E6E73; margin-top:4px;">Mentors</div></div>
    </div>

    <?php if ($me['role'] === 'owner'): ?>
    <div style="background:#fff; border:1px solid #D2D2D7; border-radius:16px; overflow-x:auto; margin-bottom:24px;">
      <div style="display:grid; grid-template-columns:1fr 140px 140px 44px; min-width:560px; padding:14px 22px; font-size:12px; font-weight:700; color:#8A93A3; letter-spacing:0.02em; border-bottom:1px solid #D2D2D7;">
        <div>E-MAIL</div><div>RÔLE</div><div>AJOUTÉ LE</div><div></div>
      </div>
      <?php foreach ($admins as $a): ?>
      <div style="display:grid; grid-template-columns:1fr 140px 140px 44px; min-width:560px; align-items:center; padding:16px 22px; border-bottom:1px solid #EEEEF0; font-size:14.5px;">
        <div style="font-weight:600;"><?= h($a['email']) ?></div>
        <div>
          <?php if ($a['role'] === 'owner'): ?>
            <span style="color:#0066CC; background:#E5F0FF; font-weight:700; font-size:11px; padding:4px 12px; border-radius:980px;">Propriétaire</span>
          <?php else: ?>
            <span style="color:#6E6E73; background:#F0F0F2; font-weight:700; font-size:11px; padding:4px 12px; border-radius:980px;">Communication</span>
          <?php endif; ?>
        </div>
        <div style="color:#8A93A3; font-size:13px;"><?= h(date('M Y', strtotime($a['created_at']))) ?></div>
        <div>
          <?php if ($a['role'] !== 'owner'): ?>
          <button data-action="delete-admin" data-id="<?= (int)$a['id'] ?>" title="Retirer cet administrateur" style="width:28px; height:28px; border-radius:50%; border:none; background:#FCE8E8; color:#D62828; font-size:14px; font-weight:700; cursor:pointer;">×</button>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div style="background:#fff; border:1px solid #D2D2D7; border-radius:16px; padding:22px; margin-bottom:24px;">
      <h3 style="font-weight:700; font-size:15px; margin:0 0 14px;">Ajouter un administrateur</h3>
      <button class="rl-btn-add" data-action="add-admin">+ Ajouter</button>
      <p style="color:#8A93A3; font-size:12px; margin:12px 0 0;">La personne recevra un mot de passe temporaire à communiquer, limité à la modification des textes, images, actualités et sponsors.</p>
    </div>
    <?php endif; ?>

    <div style="background:#fff; border:1px solid #D2D2D7; border-radius:16px; padding:22px;">
      <h3 style="font-weight:700; font-size:15px; margin:0 0 14px;">Mon compte</h3>
      <p style="color:#6E6E73; font-size:13.5px; margin:0 0 14px;"><?= h($me['email']) ?> — <?= $me['role'] === 'owner' ? 'Propriétaire' : 'Communication' ?></p>
      <button class="rl-btn-add" data-action="change-password">Changer mon mot de passe</button>
    </div>
  </main>

</div>
<script>window.RL_CSRF = <?= json_encode(csrf_token()) ?>; window.RL_EDIT_MODE = true;</script>
<script src="assets/js/editable.js"></script>
</body>
</html>
