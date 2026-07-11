<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = "FTC — FIRST® Tech Challenge — Robo'Lyon";
$activePage = 'equipes';
$teams = db()->query("SELECT * FROM teams WHERE program='FTC' ORDER BY sort_order")->fetchAll();
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 64px; text-align:center;">
      <div style="margin-bottom:16px;"><a href="equipes.php" style="font-weight:600; font-size:13px; color:#8FA0C4;"><?= h(t('common.back_to_teams')) ?></a></div>
      <div style="display:inline-block; color:#0066CC; background:#fff; font-weight:700; font-size:11.5px; padding:5px 14px; border-radius:980px; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:18px;"><?= h(team_count_label(count($teams))) ?></div>
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;">FTC — FIRST® Tech Challenge</h1>
      <?php edit_text('ftc.hero_subtitle', "Un programme de robotique accessible dès le collège — le cœur de notre saison actuelle.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:640px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section style="padding:64px 28px 96px; max-width:1180px; margin:0 auto;">
    <?php if (is_edit_mode()): ?>
    <div style="margin-bottom:24px;"><button class="rl-btn-add" data-action="add-team">+ Ajouter une équipe FTC</button></div>
    <?php endif; ?>
    <div class="rl-g2" style="grid-template-columns:repeat(2,1fr); gap:24px;">
      <?php foreach ($teams as $t): ?>
      <div style="position:relative; border:1px solid #D2D2D7; border-radius:16px; padding:28px;">
        <?php if (is_edit_mode()): ?><button class="rl-delete-x" data-action="delete-team" data-id="<?= (int)$t['id'] ?>">×</button><?php endif; ?>
        <a href="equipe-ftc.php?slug=<?= h($t['slug']) ?>" style="display:block; color:inherit;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
            <span style="color:#0066CC; background:#E5F0FF; font-weight:700; font-size:11px; padding:5px 12px; border-radius:980px; text-transform:uppercase; letter-spacing:0.03em;"><?= h($t['status_label']) ?></span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A93A3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
          </div>
          <h2 style="font-weight:700; font-size:20px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em;">FTC — <?= h($t['name']) ?></h2>
          <p style="color:#6E6E73; font-size:14px; line-height:1.6; margin:0;"><?= h(team_description($t)) ?></p>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
