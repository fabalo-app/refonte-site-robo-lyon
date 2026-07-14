<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = t('title.home');
$activePage = 'accueil';
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:64px 28px 72px; text-align:center;">
      <?php edit_text('home.hero_title', "La robotique de compétition,\nà Lyon depuis 2014.", 'h1', "font-weight:700; font-size:clamp(36px,4.6vw,50px); line-height:1.1; letter-spacing:-0.02em; color:#fff; margin:0 0 20px; max-width:760px; margin-left:auto; margin-right:auto; white-space:pre-line;"); ?>
      <?php edit_text('home.hero_subtitle', "Notre mission : donner à des collégiens et lycéens de la région lyonnaise les moyens de vivre la robotique de compétition internationale, encadrés par des mentors bénévoles.", 'p', "font-size:16.5px; color:#A9B6D6; max-width:560px; margin:0 auto 32px; line-height:1.6;"); ?>
      <div class="rl-hero-actions rl-stack-mobile" style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
        <a href="soutenir.php" style="background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px 26px; border-radius:980px;"><?php edit_text('home.cta_don', 'Faire un don', 'span'); ?></a>
        <a href="sponsors.php" style="border:1px solid rgba(255,255,255,0.35); color:#fff; font-weight:500; font-size:14.5px; padding:11px 26px; border-radius:980px;"><?php edit_text('home.cta2', 'Devenir sponsor', 'span'); ?></a>
        <a href="soutenir.php#mentor" style="border:1px solid rgba(255,255,255,0.35); color:#fff; font-weight:500; font-size:14.5px; padding:11px 26px; border-radius:980px;"><?php edit_text('home.cta_mentor', 'Devenir mentor', 'span'); ?></a>
      </div>
    </section>
  </div>

  <section style="padding:0 28px; max-width:980px; margin:-32px auto 0; position:relative;">
    <div style="aspect-ratio:16/6.6; border-radius:16px; overflow:hidden; border:1px solid #D2D2D7; box-shadow:0 20px 44px rgba(11,31,58,0.14);">
      <?php render_media('home.hero_media', t('media.hero_action')); ?>
    </div>
  </section>

  <section style="padding:64px 28px 8px;">
    <div class="rl-g4" style="max-width:980px; margin:0 auto; grid-template-columns:repeat(4,1fr); border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
      <?php
      $stats = [
        ['key' => 'home.stat1', 'num' => '2014', 'label' => 'Fondation — 1ère équipe française FRC'],
        ['key' => 'home.stat2', 'num' => '~40', 'label' => 'Membres actifs (élèves & mentors)'],
        ['key' => 'home.stat3', 'num' => '2', 'label' => 'Programmes FIRST® — FRC & FTC'],
        ['key' => 'home.stat4', 'num' => '2021', 'label' => 'Lauréat du Global Innovation Challenge'],
      ];
      foreach ($stats as $i => $s):
      ?>
      <div style="text-align:center; padding:28px 16px; <?= $i < 3 ? 'border-right:1px solid #D2D2D7;' : '' ?>">
        <?php edit_text($s['key'] . '.num', $s['num'], 'div', 'font-weight:700; font-size:clamp(24px,2.2vw,30px); color:#0B1F3A; letter-spacing:-0.01em; margin-bottom:6px;'); ?>
        <?php edit_text($s['key'] . '.label', $s['label'], 'div', 'font-size:13px; color:#6E6E73; line-height:1.4;'); ?>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section style="padding:56px 28px 96px; max-width:1180px; margin:0 auto;">
    <div style="text-align:center; margin-bottom:48px;">
      <?php edit_text('home.teams_title', 'Nos équipes de compétition', 'h2', 'font-weight:700; font-size:32px; letter-spacing:-0.015em; color:#1D1D1F; margin:0 0 10px; display:block;'); ?>
      <?php edit_text('home.teams_subtitle', 'Deux programmes FIRST®, une même passion pour la robotique.', 'p', 'color:#6E6E73; font-size:17px; margin:0;'); ?>
    </div>
    <?php
    $frc = db()->query("SELECT * FROM teams WHERE program='FRC' LIMIT 1")->fetch();
    $ftcCount = (int) db()->query("SELECT COUNT(*) c FROM teams WHERE program='FTC'")->fetch()['c'];
    ?>
    <div class="rl-g2" style="grid-template-columns:1fr 1fr; gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
      <div style="background:#fff;">
        <div style="width:100%; aspect-ratio:16/10; padding:20px; background:#F5F5F7;">
          <?php render_media('home.frc_card_media', 'Photo ou vidéo du robot FRC', 'object-fit:contain;', '', 'assets/img/robots/tenor2024-300x225.png'); ?>
        </div>
        <div style="padding:28px;">
          <?php if (is_edit_mode()): ?>
          <div style="margin-bottom:12px;"><button class="rl-btn-add" data-action="edit-team-info" data-id="<?= (int)$frc['id'] ?>" data-name="<?= h($frc['name']) ?>" data-status="<?= h($frc['status_label']) ?>" data-description="<?= h($frc['description']) ?>" data-description-en="<?= h($frc['description_en'] ?? '') ?>">✎ Modifier nom / statut / description</button></div>
          <?php endif; ?>
          <div style="display:inline-block; font-size:11px; font-weight:700; color:#D62828; letter-spacing:0.03em; margin-bottom:12px; text-transform:uppercase; background:#FCE8E8; padding:5px 12px; border-radius:980px;"><?= h($frc['status_label']) ?></div>
          <h3 style="font-weight:700; font-size:19px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em;">FRC — <?= h($frc['name']) ?></h3>
          <?php render_team_description($frc, 'p', 'color:#6E6E73; font-size:14.5px; line-height:1.6; margin:0 0 16px;'); ?>
          <a href="frc.php" style="font-weight:600; font-size:14px;"><?php edit_text('home.frc_link', "Voir l'équipe FRC \u{a0}›", 'span'); ?></a>
        </div>
      </div>
      <div style="background:#fff;">
        <div style="width:100%; aspect-ratio:16/10;">
          <?php render_media('home.ftc_card_media', 'Photo ou vidéo des équipes FTC', 'object-fit:cover;', '', 'assets/img/photos/team-photo.jpg'); ?>
        </div>
        <div style="padding:28px;">
          <?php edit_text('home.ftc_card_badge', 'Équipes actives', 'div', 'display:inline-block; font-size:11px; font-weight:700; color:#0066CC; letter-spacing:0.03em; margin-bottom:12px; text-transform:uppercase; background:#E5F0FF; padding:5px 12px; border-radius:980px;'); ?>
          <h3 style="font-weight:700; font-size:19px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em;">FTC — <?= $ftcCount ?> <?= h(team_noun($ftcCount)) ?></h3>
          <?php edit_text('home.ftc_card_desc', "Nos équipes FIRST® Tech Challenge, cœur de notre saison actuelle — le tremplin idéal pour découvrir la robotique dès le collège.", 'p', 'color:#6E6E73; font-size:14.5px; line-height:1.6; margin:0 0 16px;'); ?>
          <a href="ftc.php" style="font-weight:600; font-size:14px;"><?php edit_text('home.ftc_link', "Voir les équipes FTC \u{a0}›", 'span'); ?></a>
        </div>
      </div>
    </div>
  </section>

  <section style="background:#F5F5F7; padding:96px 28px;">
    <div style="max-width:1180px; margin:0 auto;">
      <div style="display:flex; align-items:baseline; justify-content:space-between; gap:20px; flex-wrap:wrap; margin-bottom:44px;">
        <?php edit_text('home.actus_title', 'Actualités & affiches', 'h2', 'font-weight:700; font-size:32px; letter-spacing:-0.015em; color:#1D1D1F; margin:0; display:block;'); ?>
        <a href="actus.php" style="font-weight:600; font-size:15px;"><?php edit_text('home.actus_link', "Voir toutes les actus \u{a0}›", 'span'); ?></a>
      </div>
      <?php $actus = db()->query('SELECT * FROM actus ORDER BY published_at DESC, id DESC LIMIT 3')->fetchAll(); ?>
      <?php if ($actus): ?>
      <div class="rl-g3" style="grid-template-columns:repeat(3,1fr); gap:24px;">
        <?php foreach ($actus as $a): ?>
        <div style="background:#fff; border:1px solid #D2D2D7; border-radius:14px; overflow:hidden;">
          <div style="aspect-ratio:4/3; border-bottom:1px solid #D2D2D7; background:#F5F5F7; display:flex; align-items:center; justify-content:center;">
            <?php if ($a['image_path']): ?>
              <img src="<?= h(UPLOADS_URL . '/' . $a['image_path']) ?>" alt="Affiche : <?= h($a['title']) ?>" style="width:100%; height:100%; object-fit:cover;">
            <?php else: ?>
              <span style="color:#9AA0A6; font-size:12.5px;"><?= h(t('actus.poster_soon')) ?></span>
            <?php endif; ?>
          </div>
          <div style="padding:20px;">
            <div style="color:#6E6E73; font-weight:600; font-size:12.5px; letter-spacing:0.02em; margin-bottom:8px; text-transform:uppercase;"><?= h($a['date_label']) ?></div>
            <h3 style="font-weight:700; font-size:16px; color:#1D1D1F; margin:0; letter-spacing:-0.005em;"><?= h($a['title']) ?></h3>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <p style="color:#6E6E73; font-size:15px;"><?= h(t('page.actus.empty_title')) ?></p>
      <?php endif; ?>
    </div>
  </section>

  <section style="padding:96px 28px; max-width:1180px; margin:0 auto;">
    <div style="text-align:center; margin-bottom:44px;">
      <?php edit_text('home.sponsors_title', 'Merci à nos sponsors', 'h2', 'font-weight:700; font-size:32px; letter-spacing:-0.015em; color:#1D1D1F; margin:0 0 10px; display:block;'); ?>
      <?php edit_text('home.sponsors_subtitle', "Ils rendent l'aventure Robo'Lyon possible chaque année.", 'p', 'color:#6E6E73; font-size:17px; margin:0;'); ?>
    </div>
    <div class="rl-g6" style="grid-template-columns:repeat(6,1fr); gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:14px; overflow:hidden;">
      <?php foreach (db()->query('SELECT * FROM sponsors ORDER BY sort_order') as $sp): ?>
      <div style="background:#fff; height:96px; display:flex; align-items:center; justify-content:center; padding:14px;">
        <img src="<?= h(UPLOADS_URL . '/' . $sp['logo_path']) ?>" alt="<?= h($sp['name']) ?>" style="max-height:48px; max-width:100%; width:auto; object-fit:contain;">
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center; margin-top:36px;">
      <a href="sponsors.php" style="font-weight:600; font-size:15px;"><?php edit_text('home.sponsors_link', "Voir tous nos sponsors \u{a0}›", 'span'); ?></a>
    </div>
  </section>

  <section style="background:#0B1F3A; padding:72px 28px;">
    <div class="rl-stack-mobile" style="max-width:1180px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:28px; flex-wrap:wrap;">
      <div>
        <?php edit_text('home.cta_title', "Envie de nous aider à voler plus haut ?", 'h2', "font-weight:700; font-size:26px; letter-spacing:-0.01em; color:#fff; margin:0 0 8px;"); ?>
        <?php edit_text('home.cta_subtitle', "Chaque soutien compte — retrouvez tous les moyens d'agir ci-dessus.", 'p', "color:#A9B6D6; font-size:15.5px; margin:0;"); ?>
      </div>
      <a href="contact.php" style="color:#fff; font-weight:500; font-size:14.5px; white-space:nowrap;"><?php edit_text('home.cta_contact', "Nous contacter \u{a0}›", 'span'); ?></a>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
