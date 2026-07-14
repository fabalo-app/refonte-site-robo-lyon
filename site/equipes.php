<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = t('title.equipes');
$activePage = 'equipes';
require __DIR__ . '/includes/partials/head.php';

$frc = db()->query("SELECT * FROM teams WHERE program='FRC' LIMIT 1")->fetch();
$ftcTeams = db()->query("SELECT * FROM teams WHERE program='FTC' ORDER BY sort_order")->fetchAll();
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 64px; text-align:center;">
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;"><?= h(t('nav.equipes')) ?></h1>
      <?php edit_text('equipes.hero_subtitle', "Deux programmes FIRST®, une même passion pour la robotique de compétition.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:600px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section style="padding:64px 28px 40px; max-width:1180px; margin:0 auto;">
    <div class="rl-g2" style="grid-template-columns:1fr 1fr; gap:24px;">
      <div style="border:1px solid #D2D2D7; border-radius:18px; overflow:hidden;">
        <div style="width:100%; aspect-ratio:16/10; padding:22px; background:#F5F5F7;">
          <?php render_media('equipes.frc_card_media', 'Photo ou vidéo du robot FRC', 'object-fit:contain;', '', 'assets/img/robots/tenor2024-300x225.png'); ?>
        </div>
        <div style="padding:28px;">
          <?php if (is_edit_mode()): ?>
          <div style="margin-bottom:12px;"><button class="rl-btn-add" data-action="edit-team-info" data-id="<?= (int)$frc['id'] ?>" data-name="<?= h($frc['name']) ?>" data-status="<?= h($frc['status_label']) ?>" data-description="<?= h($frc['description']) ?>" data-description-en="<?= h($frc['description_en'] ?? '') ?>">✎ Modifier nom / statut / description</button></div>
          <?php endif; ?>
          <div style="display:inline-block; font-size:11px; font-weight:700; color:#D62828; letter-spacing:0.03em; margin-bottom:12px; text-transform:uppercase; background:#FCE8E8; padding:5px 12px; border-radius:980px;"><?= h($frc['status_label']) ?></div>
          <h2 style="font-weight:700; font-size:22px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em;">FRC — <?= h($frc['name']) ?></h2>
          <?php render_team_description($frc, 'p', 'color:#6E6E73; font-size:14.5px; line-height:1.6; margin:0 0 16px;'); ?>
          <a href="frc.php" style="font-weight:600; font-size:14px; color:#0066CC;"><?php edit_text('equipes.frc_link', "Découvrir l'équipe FRC \u{a0}›", 'span'); ?></a>
        </div>
      </div>
      <div style="border:1px solid #D2D2D7; border-radius:18px; overflow:hidden;">
        <div style="width:100%; aspect-ratio:16/10;">
          <?php render_media('equipes.ftc_card_media', 'Photo ou vidéo des équipes FTC', 'object-fit:cover;', '', 'assets/img/photos/team-photo.jpg'); ?>
        </div>
        <div style="padding:28px;">
          <div style="display:inline-block; font-size:11px; font-weight:700; color:#0066CC; letter-spacing:0.03em; margin-bottom:12px; text-transform:uppercase; background:#E5F0FF; padding:5px 12px; border-radius:980px;"><?= h(team_count_label(count($ftcTeams))) ?></div>
          <h2 style="font-weight:700; font-size:22px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em;">FTC — FIRST® Tech Challenge</h2>
          <?php edit_text('equipes.ftc_card_desc', 'Nos équipes FIRST® Tech Challenge, cœur de notre saison actuelle. Membres, robots et projets de chaque équipe.', 'p', 'color:#6E6E73; font-size:14.5px; line-height:1.6; margin:0 0 16px;'); ?>
          <a href="ftc.php" style="font-weight:600; font-size:14px; color:#0066CC;"><?php edit_text('equipes.ftc_link', "Découvrir les équipes FTC \u{a0}›", 'span'); ?></a>
        </div>
      </div>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
