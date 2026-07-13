<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = "Actualités — Robo'Lyon";
$activePage = 'actus';
$actus = db()->query('SELECT * FROM actus ORDER BY published_at DESC, id DESC')->fetchAll();
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 64px; text-align:center;">
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;"><?= h(t('page.actus.title')) ?></h1>
      <?php edit_text('actus.hero_subtitle', "Toutes les annonces et affiches de l'association, mises à jour par l'équipe communication.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:600px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section style="padding:72px 28px 112px; max-width:1180px; margin:0 auto;">
    <?php if (is_edit_mode()): ?>
    <div style="margin-bottom:32px; text-align:center;"><button class="rl-btn-add" data-action="add-actu"><?= h(t('common.add')) ?></button></div>
    <?php endif; ?>

    <?php if ($actus): ?>
    <div class="rl-g3" style="grid-template-columns:repeat(3,1fr); gap:24px;">
      <?php foreach ($actus as $a): ?>
      <div style="position:relative; background:#fff; border:1px solid #D2D2D7; border-radius:14px; overflow:hidden;">
        <?php if (is_edit_mode()): ?><button class="rl-delete-x" data-action="delete-actu" data-id="<?= (int)$a['id'] ?>">×</button><?php endif; ?>
        <div style="aspect-ratio:4/3; border-bottom:1px solid #D2D2D7; background:#F5F5F7; display:flex; align-items:center; justify-content:center;">
          <?php if ($a['image_path']): ?>
            <img src="<?= h(UPLOADS_URL . '/' . $a['image_path']) ?>" alt="Affiche : <?= h($a['title']) ?>" style="width:100%; height:100%; object-fit:cover;">
          <?php else: ?>
            <span style="color:#9AA0A6; font-size:12.5px;"><?= h(t('actus.poster_soon')) ?></span>
          <?php endif; ?>
        </div>
        <div style="padding:20px;">
          <div style="color:#6E6E73; font-weight:600; font-size:12.5px; letter-spacing:0.02em; margin-bottom:8px; text-transform:uppercase;"><?= h($a['date_label']) ?> · <?= h(date('d/m/Y', strtotime($a['published_at']))) ?></div>
          <h3 style="font-weight:700; font-size:16px; color:#1D1D1F; margin:0; letter-spacing:-0.005em;"><?= h($a['title']) ?></h3>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="max-width:720px; margin:0 auto; border:1px solid #D2D2D7; border-radius:18px; padding:64px 40px; text-align:center;">
      <h2 style="font-weight:700; font-size:19px; color:#1D1D1F; margin:0 0 10px;"><?= h(t('page.actus.empty_title')) ?></h2>
      <p style="color:#6E6E73; font-size:15px; line-height:1.6; margin:0 0 28px;"><?= h(t('page.actus.empty_desc')) ?></p>
      <div class="rl-stack-mobile" style="display:flex; gap:24px; justify-content:center; flex-wrap:wrap;">
        <?php render_editable_link('social.instagram', 'Instagram', '#', 'font-weight:600; font-size:14px;'); ?>
        <?php render_editable_link('social.facebook', 'Facebook', '#', 'font-weight:600; font-size:14px;'); ?>
      </div>
    </div>
    <?php endif; ?>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
