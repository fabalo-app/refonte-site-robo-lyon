<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = t('title.association');
$activePage = 'association';
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 64px; text-align:center;">
      <div style="font-weight:600; font-size:13.5px; color:#9FC4FF; margin-bottom:16px; text-transform:uppercase; letter-spacing:0.04em;"><?= h(t('assoc.since')) ?></div>
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;"><?= h(t('nav.association')) ?></h1>
      <?php edit_text('assoc.hero_subtitle', "Notre histoire, nos valeurs et nos missions — une aventure humaine et technique, portée par des jeunes et des bénévoles passionnés.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:600px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section id="histoire" style="padding:72px 28px 64px; max-width:900px; margin:0 auto;">
    <h2 style="font-weight:700; font-size:26px; letter-spacing:-0.015em; color:#1D1D1F; margin:0 0 24px;"><?= h(t('nav.histoire')) ?></h2>
    <?php edit_text('assoc.histoire_p1', "Robo'Lyon est une association de robotique basée au Lycée Notre Dame de Bellegarde, à Neuville-sur-Saône (69). Nous sommes fiers d'être la première équipe française à avoir participé à la FIRST® Robotics Competition, dès 2014.", 'p', 'font-size:16.5px; line-height:1.7; color:#3A3A3C; margin:0 0 18px;'); ?>
    <?php edit_text('assoc.histoire_p2', "L'association réunit aujourd'hui environ 40 membres : une trentaine d'élèves de collège et lycée (dont près d'un tiers de filles), accompagnés d'une dizaine de mentors — parents, enseignants, professionnels et anciens élèves.", 'p', 'font-size:16.5px; line-height:1.7; color:#3A3A3C; margin:0 0 18px;'); ?>
    <?php edit_text('assoc.histoire_p3', "Nous proposons un parcours robotique innovant qui prépare les jeunes à des compétitions internationales de haut niveau, au sein de deux programmes FIRST® : la FRC (équipe 5553, en pause cette année) et la FTC, désormais forte de plusieurs équipes — notre priorité de développement cette saison.", 'p', 'font-size:16.5px; line-height:1.7; color:#3A3A3C; margin:0 0 32px;'); ?>
    <div style="border-radius:20px; overflow:hidden; border:1px solid #D2D2D7; aspect-ratio:16/8;">
      <?php render_media('assoc.histoire_media', t('media.team_photo')); ?>
    </div>
  </section>

  <section id="frc-ftc" style="background:#F5F5F7; padding:64px 28px;">
    <div class="rl-g2" style="max-width:1180px; margin:0 auto; grid-template-columns:1fr 1fr; gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
      <div style="background:#fff; padding:30px;">
        <div style="display:inline-block; font-size:11px; font-weight:700; color:#D62828; letter-spacing:0.03em; margin-bottom:12px; text-transform:uppercase; background:#FCE8E8; padding:5px 12px; border-radius:980px;">FRC</div>
        <?php edit_text('assoc.frc_explain_title', "Qu'est-ce que la FRC ?", 'h3', 'font-weight:700; font-size:18px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em; display:block;'); ?>
        <?php edit_text('assoc.frc_explain', "La FIRST® Robotics Competition est le programme le plus avancé de FIRST® : des lycéens conçoivent, fabriquent et pilotent en 6 semaines un robot de compétition, pour affronter d'autres équipes du monde entier lors de tournois internationaux.", 'p', 'color:#6E6E73; font-size:14px; line-height:1.65; margin:0 0 12px;'); ?>
        <a href="frc.php" style="font-weight:600; font-size:13.5px;"><?php edit_text('assoc.frc_link', 'Découvrir notre équipe FRC ›', 'span'); ?></a>
      </div>
      <div style="background:#fff; padding:30px;">
        <div style="display:inline-block; font-size:11px; font-weight:700; color:#0066CC; letter-spacing:0.03em; margin-bottom:12px; text-transform:uppercase; background:#E5F0FF; padding:5px 12px; border-radius:980px;">FTC</div>
        <?php edit_text('assoc.ftc_explain_title', "Qu'est-ce que la FTC ?", 'h3', 'font-weight:700; font-size:18px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em; display:block;'); ?>
        <?php edit_text('assoc.ftc_explain', "La FIRST® Tech Challenge est un programme accessible dès le collège : par équipes plus petites, les élèves conçoivent un robot avec un budget et des règles plus simples que la FRC — un excellent tremplin vers la robotique de compétition.", 'p', 'color:#6E6E73; font-size:14px; line-height:1.65; margin:0 0 12px;'); ?>
        <a href="ftc.php" style="font-weight:600; font-size:13.5px;"><?php edit_text('assoc.ftc_link', 'Découvrir nos équipes FTC ›', 'span'); ?></a>
      </div>
    </div>
  </section>

  <section id="mentors" style="padding:80px 28px; max-width:1180px; margin:0 auto;">
    <div style="text-align:center; margin-bottom:44px;">
      <?php edit_text('assoc.mentors_title', 'Nos mentors', 'h2', 'font-weight:700; font-size:28px; letter-spacing:-0.015em; color:#1D1D1F; margin:0 0 8px; display:block;'); ?>
      <?php edit_text('assoc.mentors_subtitle', "Parents, enseignants, ingénieurs, anciens élèves : ils accompagnent bénévolement les jeunes tout au long de la saison.", 'p', 'color:#6E6E73; font-size:16px; margin:0;'); ?>
    </div>
    <?php if (is_edit_mode()): ?>
    <div style="text-align:center; margin-bottom:28px;"><button class="rl-btn-add" data-action="add-mentor"><?= h(t('common.add')) ?></button></div>
    <?php endif; ?>
    <div class="rl-g4" style="grid-template-columns:repeat(4,1fr); gap:20px;">
      <?php foreach (db()->query('SELECT * FROM mentors ORDER BY sort_order') as $mt): ?>
      <div style="position:relative; text-align:center; border:1px solid #D2D2D7; border-radius:16px; padding:22px;">
        <?php if (is_edit_mode()): ?><button class="rl-delete-x" data-action="delete-mentor" data-id="<?= (int)$mt['id'] ?>">×</button><?php endif; ?>
        <div style="width:72px; height:72px; border-radius:50%; overflow:hidden; margin:0 auto 14px; background:#F5F5F7; display:flex; align-items:center; justify-content:center;">
          <?php if ($mt['photo_path']): ?>
            <img src="<?= h(UPLOADS_URL . '/' . $mt['photo_path']) ?>" alt="Photo de <?= h($mt['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
          <?php else: ?>
            <span style="color:#9AA0A6; font-size:10px;"><?= h(t('media.photo_placeholder')) ?></span>
          <?php endif; ?>
        </div>
        <?php edit_text('mentor.' . $mt['id'] . '.name', $mt['name'], 'div', 'font-weight:700; font-size:14.5px; color:#1D1D1F; margin-bottom:4px;'); ?>
        <?php edit_text('mentor.' . $mt['id'] . '.role', $mt['role'], 'div', 'font-size:12.5px; color:#6E6E73;'); ?>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="activites" style="background:#F5F5F7; padding:80px 28px;">
    <div style="max-width:1180px; margin:0 auto;">
      <h2 style="font-weight:700; font-size:28px; letter-spacing:-0.015em; color:#1D1D1F; margin:0 0 8px; text-align:center;"><?= h(t('nav.activites')) ?></h2>
      <p style="color:#6E6E73; font-size:16px; margin:0 0 44px; text-align:center;"><?= h(t('assoc.activites_subtitle')) ?></p>
      <div class="rl-g3" style="grid-template-columns:repeat(3,1fr); gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
        <?php
        $activites = [
          ['key' => 'assoc.act1', 'title' => 'Technique', 'desc' => 'Imaginer un mécanisme, concevoir en CAO, prototyper, programmer, piloter le robot — CAO, découpe CNC, impression 3D et pneumatique.'],
          ['key' => 'assoc.act2', 'title' => 'Communication', 'desc' => "Animer les réseaux sociaux, faire vivre le site, produire de la documentation et des vidéos, trouver des sponsors, organiser des événements."],
          ['key' => 'assoc.act3', 'title' => 'Méthode', 'desc' => "Une organisation agile : réunions hebdomadaires, petits groupes, suivi de projet — et le développement du travail d'équipe, de la résilience et de la prise de parole."],
        ];
        foreach ($activites as $a):
        ?>
        <div style="background:#fff; padding:30px;">
          <?php edit_text($a['key'] . '.title', $a['title'], 'h3', 'font-weight:700; font-size:17px; color:#1D1D1F; margin:0 0 10px; letter-spacing:-0.01em; display:block;'); ?>
          <?php edit_text($a['key'] . '.desc', $a['desc'], 'p', 'color:#6E6E73; font-size:14px; line-height:1.65; margin:0;'); ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="valeurs" style="padding:80px 28px; max-width:1180px; margin:0 auto;">
    <h2 style="font-weight:700; font-size:28px; letter-spacing:-0.015em; color:#1D1D1F; margin:0 0 20px; text-align:center;"><?= h(t('nav.valeurs')) ?></h2>
    <p style="color:#6E6E73; font-size:15.5px; max-width:680px; margin:0 auto 44px; text-align:center; line-height:1.7;"><?= t('assoc.valeurs_intro') ?></p>
    <div class="rl-g5" style="grid-template-columns:repeat(5,1fr); gap:0; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
      <?php
      $valeurs = [
        ['key' => 'assoc.val1', 'title' => 'Découverte', 'desc' => 'Explorer de nouvelles compétences et de nouvelles idées.'],
        ['key' => 'assoc.val2', 'title' => 'Innovation', 'desc' => 'Créativité et persévérance pour résoudre des problèmes.'],
        ['key' => 'assoc.val3', 'title' => 'Impact', 'desc' => "Mettre nos apprentissages au service d'un changement positif."],
        ['key' => 'assoc.val4', 'title' => 'Inclusion', 'desc' => 'Se respecter et valoriser nos différences.'],
        ['key' => 'assoc.val5', 'title' => "Travail d'équipe", 'desc' => "Reconnaître la force du collectif et s'épanouir en collaborant."],
      ];
      foreach ($valeurs as $i => $v):
      ?>
      <div style="padding:24px 14px; <?= $i < 4 ? 'border-right:1px solid #D2D2D7;' : '' ?> text-align:center;">
        <?php edit_text($v['key'] . '.title', $v['title'], 'h3', 'font-weight:700; font-size:14.5px; color:#1D1D1F; margin:0 0 8px; display:block;'); ?>
        <?php edit_text($v['key'] . '.desc', $v['desc'], 'p', 'font-size:12.5px; color:#6E6E73; margin:0; line-height:1.5;'); ?>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="missions" style="background:#0B1F3A; padding:80px 28px;">
    <div style="max-width:800px; margin:0 auto;">
      <h2 style="font-weight:700; font-size:28px; letter-spacing:-0.015em; color:#fff; margin:0 0 32px; text-align:center;"><?= h(t('nav.missions')) ?></h2>
      <div style="display:flex; flex-direction:column; gap:18px; margin-bottom:32px;">
        <?php
        $missions = [
          ['key' => 'assoc.mission1', 'text' => "Susciter l'intérêt pour les sciences et la technologie auprès des jeunes de notre région."],
          ['key' => 'assoc.mission2', 'text' => "Faire rayonner FIRST® partout en France pour développer sa communauté."],
          ['key' => 'assoc.mission3', 'text' => "Accompagner la création de nouvelles équipes françaises de robotique."],
          ['key' => 'assoc.mission4', 'text' => "Renforcer les liens avec les autres organisations de robotique européennes."],
          ['key' => 'assoc.mission5', 'text' => "Développer une compétition régionale française de robotique."],
        ];
        foreach ($missions as $i => $m):
        $bg = $i % 2 === 0 ? 'rgba(214,40,40,0.08)' : 'rgba(255,255,255,0.06)';
        ?>
        <div style="display:flex; gap:16px; align-items:flex-start; background:<?= $bg ?>; border-radius:12px; padding:16px 18px;">
          <span style="color:#D62828; font-weight:700; font-size:13px;"><?= sprintf('%02d', $i + 1) ?></span>
          <?php edit_text($m['key'], $m['text'], 'p', 'margin:0; color:#C7D2E8; font-size:15.5px; line-height:1.6;'); ?>
        </div>
        <?php endforeach; ?>
      </div>
      <?php edit_text('assoc.mission_footer', "Cette vision a notamment conduit au lancement de Robotique FIRST France, le 15 mars 2022 au Ministère de l'Industrie, avec Robo'Lyon comme moteur du projet.", 'p', 'color:#A9B6D6; font-size:14.5px; line-height:1.7; text-align:center; margin:0;'); ?>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
