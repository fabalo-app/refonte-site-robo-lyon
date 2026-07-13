<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = "FRC — Équipe 5553 — Robo'Lyon";
$activePage = 'equipes';
$team = db()->query("SELECT * FROM teams WHERE program='FRC' LIMIT 1")->fetch();
$membersStmt = db()->prepare('SELECT * FROM team_members WHERE team_id = ? ORDER BY sort_order');
$membersStmt->execute([$team['id']]);
$members = $membersStmt->fetchAll();

$robots = [
    ['slug' => 'tenor', 'year' => '2024', 'name' => 'Tenor', 'img' => 'assets/img/robots/tenor2024-300x225.png',
        'desc' => "Tenor est conçu pour saisir, transporter et empiler des notes de jeu tout en grimpant sur la structure de fin de match — mécanique à chaîne, bras articulé et système pneumatique, piloté par une programmation embarquée en Java (WPILib).", 'weight' => '54'],
    ['slug' => 'antares-2', 'year' => '2019', 'name' => 'Antares 2', 'img' => 'assets/img/robots/antares_800x800-300x300.png', 'desc' => null, 'weight' => null],
    ['slug' => 'archimede', 'year' => '2018', 'name' => 'Archimède', 'img' => 'assets/img/robots/archimede_800x800-300x300.png', 'desc' => null, 'weight' => null],
    ['slug' => 'scorpion', 'year' => '2018', 'name' => 'Scorpion', 'img' => 'assets/img/robots/scorpion_800x800-300x300.png', 'desc' => null, 'weight' => null],
    ['slug' => 'zeppelin', 'year' => '2017', 'name' => 'Zeppelin', 'img' => 'assets/img/robots/zeppelin_800x800-300x300.png', 'desc' => null, 'weight' => null],
];
$palmares = [
    ['key' => 'frc.p1', 'title' => 'Qualifications au championnat mondial', 'detail' => '2017 (St. Louis), 2018 (Detroit), 2020 (Houston), 2023 (Houston)'],
    ['key' => 'frc.p2', 'title' => 'Victoire régionale', 'detail' => 'Régionale de Montréal, 2017'],
    ['key' => 'frc.p3', 'title' => 'Prix Innovation', 'detail' => 'Innovation Challenge, 2021'],
    ['key' => 'frc.p4', 'title' => "Prix Chairman's & Impact", 'detail' => '2017 et 2023'],
    ['key' => 'frc.p5', 'title' => 'Engineering Inspiration', 'detail' => '2018 et 2020'],
    ['key' => 'frc.p6', 'title' => 'Prix Créativité', 'detail' => '2024'],
];
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 48px; text-align:center;">
      <div style="display:inline-flex; gap:28px; margin-bottom:20px;">
        <span style="font-weight:600; font-size:13px; color:#8FA0C4;"><a href="equipes.php" style="color:#8FA0C4;"><?= h(t('common.back_to_teams')) ?></a></span>
      </div>
      <div style="display:inline-block; color:#D62828; background:#fff; font-weight:700; font-size:11.5px; padding:5px 14px; border-radius:980px; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:18px;"><?= h($team['status_label']) ?></div>
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;">FRC — <?= h($team['name']) ?></h1>
      <?php edit_text('frc.hero_subtitle', "FIRST® Robotics Competition — première équipe française à avoir rejoint la compétition, en 2014.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:640px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section style="padding:64px 28px 56px; max-width:900px; margin:0 auto;">
    <?php if (is_edit_mode()): ?>
    <div style="margin-bottom:16px;">
      <button class="rl-btn-add" data-action="edit-team-info" data-id="<?= (int)$team['id'] ?>" data-name="<?= h($team['name']) ?>" data-status="<?= h($team['status_label']) ?>" data-description="<?= h($team['description']) ?>" data-description-en="<?= h($team['description_en'] ?? '') ?>">✎ Modifier nom / statut / description</button>
    </div>
    <?php endif; ?>
    <p style="font-size:16px; line-height:1.7; color:#3A3A3C; margin:0;"><?= h(team_description($team)) ?></p>
  </section>

  <section style="background:#F5F5F7; padding:64px 28px;">
    <div style="max-width:1180px; margin:0 auto;">
      <h2 style="font-weight:700; font-size:26px; color:#1D1D1F; margin:0 0 24px; letter-spacing:-0.015em;"><?= h(t('robot.palmares')) ?></h2>
      <div class="rl-g3" style="grid-template-columns:repeat(3,1fr); gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
        <?php foreach ($palmares as $p): ?>
        <div style="background:#fff; padding:24px;">
          <?php edit_text($p['key'] . '.title', $p['title'], 'h4', 'font-weight:700; font-size:14.5px; color:#1D1D1F; margin:0 0 6px; display:block;'); ?>
          <?php edit_text($p['key'] . '.detail', $p['detail'], 'p', 'font-size:13px; color:#6E6E73; margin:0;'); ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section style="padding:64px 28px; max-width:1180px; margin:0 auto;">
    <h2 style="font-weight:700; font-size:26px; color:#1D1D1F; margin:0 0 20px; letter-spacing:-0.015em;"><?= h(t('robot.title')) ?></h2>
    <div data-season-group>
    <div class="rl-season-tabs" style="margin-bottom:28px;">
      <?php foreach ($robots as $i => $r): ?>
      <button type="button" data-season-tab="<?= h($r['slug']) ?>" class="<?= $i === 0 ? 'rl-season-active' : '' ?>"><?= h($r['year']) ?> — <?= h($r['name']) ?></button>
      <?php endforeach; ?>
    </div>
    <?php foreach ($robots as $i => $r): ?>
    <div data-season-panel="<?= h($r['slug']) ?>" style="<?= $i === 0 ? '' : 'display:none;' ?>">
      <div class="rl-g2" style="grid-template-columns:1fr 1fr; gap:40px; align-items:center;">
        <div style="border-radius:16px; overflow:hidden; aspect-ratio:4/3; background:#F5F5F7;">
          <?php if ($r['slug'] === 'tenor'): ?>
            <?php render_media('frc.robot_media', 'Photo du robot', 'object-fit:contain; padding:20px;', '', $r['img'], 'Robot ' . $r['name'] . ' (' . $r['year'] . ')'); ?>
          <?php else: ?>
            <img src="<?= h($r['img']) ?>" alt="Robot <?= h($r['name']) ?> (<?= h($r['year']) ?>)" style="width:100%; height:100%; object-fit:contain; padding:20px;">
          <?php endif; ?>
        </div>
        <div>
          <?php edit_text('frc.robot.' . $r['slug'] . '.desc', $r['desc'] ?? 'Description à compléter par l\'équipe — ce que fait le robot, son mécanisme, sa stratégie de jeu.', 'p', 'font-size:15.5px; line-height:1.7; color:#3A3A3C; margin:0 0 14px;'); ?>
          <div style="margin-bottom:20px; font-size:14px; color:#6E6E73;">
            <?= h(t('robot.weight')) ?> : <?php edit_text('frc.robot.' . $r['slug'] . '.weight', $r['weight'] !== null ? $r['weight'] . ' kg' : 'À compléter', 'span', 'font-weight:700; color:#1D1D1F;'); ?>
          </div>
          <div style="display:flex; gap:14px; flex-wrap:wrap; align-items:center; margin-bottom:16px;">
            <?php render_editable_link('frc.robot.' . $r['slug'] . '.code', t('robot.code'), '#', 'display:inline-flex; align-items:center; gap:8px; border:1px solid #D2D2D7; color:#1D1D1F; font-weight:600; font-size:13.5px; padding:10px 20px; border-radius:980px;'); ?>
          </div>
          <?php render_model_viewer('frc.robot.' . $r['slug'], t('robot.model'), '#', 'display:inline-flex; align-items:center; gap:8px; border:1px solid #D2D2D7; color:#1D1D1F; font-weight:600; font-size:13.5px; padding:10px 20px; border-radius:980px;'); ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    </div>
  </section>

  <section style="background:#F5F5F7; padding:64px 28px;">
    <div style="max-width:1180px; margin:0 auto;">
      <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:8px; flex-wrap:wrap;">
        <h2 style="font-weight:700; font-size:26px; color:#1D1D1F; margin:0; letter-spacing:-0.015em;"><?= h(t('robot.team')) ?></h2>
        <?php if (is_edit_mode()): ?><button class="rl-btn-add" data-action="add-member" data-team-id="<?= (int)$team['id'] ?>"><?= h(t('robot.add_member')) ?></button><?php endif; ?>
      </div>
      <p style="color:#6E6E73; font-size:14.5px; margin:0 0 32px;"><?= h(t('frc.team_subtitle')) ?></p>
      <div class="rl-g5" style="grid-template-columns:repeat(5,1fr); gap:16px;">
        <?php foreach ($members as $m): ?>
        <div style="background:#fff; border:1px solid #D2D2D7; border-radius:14px; padding:18px; text-align:center; position:relative;">
          <?php if (is_edit_mode()): ?><button class="rl-delete-x" data-action="delete-member" data-id="<?= (int)$m['id'] ?>">×</button><?php endif; ?>
          <div style="width:64px; height:64px; border-radius:50%; overflow:hidden; margin:0 auto 12px; background:#F5F5F7; display:flex; align-items:center; justify-content:center;">
            <?php if ($m['photo_path']): ?>
              <img src="<?= h(UPLOADS_URL . '/' . $m['photo_path']) ?>" alt="Photo de <?= h($m['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
            <?php else: ?>
              <span style="color:#9AA0A6; font-size:10px;"><?= h(t('media.photo_placeholder')) ?></span>
            <?php endif; ?>
          </div>
          <?php edit_text('member.' . $m['id'] . '.name', $m['name'], 'div', 'font-weight:700; font-size:13.5px; color:#1D1D1F; margin-bottom:4px;'); ?>
          <?php edit_text('member.' . $m['id'] . '.role', $m['role'], 'div', 'font-size:12px; color:#6E6E73;'); ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
