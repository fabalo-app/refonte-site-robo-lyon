<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = "Sponsors — Robo'Lyon";
$activePage = 'sponsors';
$sponsors = db()->query('SELECT * FROM sponsors ORDER BY sort_order')->fetchAll();
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 64px; text-align:center;">
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;"><?= h(t('page.sponsors.title')) ?></h1>
      <?php edit_text('sponsors.hero_subtitle', "Merci à toutes les entreprises et organisations qui rendent l'aventure Robo'Lyon possible.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:600px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section style="padding:64px 28px 64px; max-width:1180px; margin:0 auto;">
    <?php if (is_edit_mode()): ?>
    <div style="margin-bottom:24px; text-align:center;"><button class="rl-btn-add" data-action="add-sponsor"><?= h(t('common.add')) ?></button></div>
    <?php endif; ?>
    <div class="rl-g6" style="grid-template-columns:repeat(6,1fr); gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:14px; overflow:hidden;">
      <?php foreach ($sponsors as $sp): ?>
      <div style="position:relative; background:#fff; height:100px; display:flex; align-items:center; justify-content:center; padding:14px;">
        <?php if (is_edit_mode()): ?><button class="rl-delete-x" data-action="delete-sponsor" data-id="<?= (int)$sp['id'] ?>">×</button><?php endif; ?>
        <img src="<?= h(UPLOADS_URL . '/' . $sp['logo_path']) ?>" alt="<?= h($sp['name']) ?>" style="max-height:50px; max-width:100%; width:auto; object-fit:contain;">
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section style="background:#F5F5F7; padding:80px 28px;">
    <div style="max-width:900px; margin:0 auto;">
      <?php edit_text('sponsors.why_title', 'Pourquoi nous soutenir ?', 'h2', 'font-weight:700; font-size:24px; letter-spacing:-0.015em; color:#1D1D1F; margin:0 0 16px; display:block;'); ?>
      <?php edit_text('sponsors.why', "Votre soutien permet à des jeunes de la région de vivre une aventure humaine et technique unique, de développer des compétences en sciences, en ingénierie et en travail d'équipe, tout en représentant la France dans des compétitions internationales.", 'p', 'font-size:16px; line-height:1.7; color:#3A3A3C; margin:0 0 48px;'); ?>
      <?php edit_text('sponsors.how_title', 'Comment nous soutenir ?', 'h2', 'font-weight:700; font-size:20px; letter-spacing:-0.01em; color:#1D1D1F; margin:0 0 24px; display:block;'); ?>
      <div class="rl-g4" style="grid-template-columns:repeat(4,1fr); gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
        <?php
        $items = [
          ['key' => 'sponsors.how1', 'title' => 'Ressources techniques', 'desc' => 'Matériel, expertise ou infrastructures.'],
          ['key' => 'sponsors.how2', 'title' => 'Mentorat', 'desc' => 'Accompagnement par des professionnels bénévoles.'],
          ['key' => 'sponsors.how3', 'title' => 'Don financier', 'desc' => "Mécénat d'entreprise ou don ponctuel."],
          ['key' => 'sponsors.how4', 'title' => 'Nos événements', 'desc' => 'Visibilité lors de nos compétitions publiques.'],
        ];
        foreach ($items as $it):
        ?>
        <div style="background:#fff; padding:22px;">
          <?php edit_text($it['key'] . '.title', $it['title'], 'h3', 'font-weight:700; font-size:14.5px; color:#1D1D1F; margin:0 0 8px; display:block;'); ?>
          <?php edit_text($it['key'] . '.desc', $it['desc'], 'p', 'font-size:13px; color:#6E6E73; margin:0; line-height:1.55;'); ?>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="rl-stack-mobile" style="text-align:center; margin-top:44px; display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
        <a href="contact.php" style="background:#D62828; color:#fff; font-weight:600; font-size:15px; padding:12px 26px; border-radius:980px; display:inline-block;"><?php edit_text('sponsors.cta', 'Nous contacter pour sponsoriser', 'span'); ?></a>
        <?php render_document('sponsors.dossier', t('sponsors.dossier_label')); ?>
      </div>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
