<?php
require_once __DIR__ . '/includes/bootstrap.php';

$slug = (string)($_GET['slug'] ?? '');
$stmt = db()->prepare("SELECT * FROM teams WHERE slug = ? AND program = 'FTC'");
$stmt->execute([$slug]);
$team = $stmt->fetch();

if (!$team) {
    http_response_code(404);
    $pageTitle = t('title.team_not_found');
    require __DIR__ . '/includes/partials/head.php';
    echo '<div style="max-width:600px; margin:80px auto; text-align:center; font-family:Inter,sans-serif;"><h1>' . h(t('error.team_not_found')) . '</h1><p><a href="ftc.php">' . h(t('common.back_to_ftc')) . '</a></p></div>';
    require __DIR__ . '/includes/partials/footer_minimal.php';
    exit;
}

$membersStmt = db()->prepare('SELECT * FROM team_members WHERE team_id = ? ORDER BY sort_order');
$membersStmt->execute([$team['id']]);
$members = $membersStmt->fetchAll();

$pageTitle = "FTC — " . $team['name'] . " — Robo'Lyon";
$activePage = 'equipes';
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 48px; text-align:center;">
      <div style="margin-bottom:20px;"><a href="ftc.php" style="font-weight:600; font-size:13px; color:#8FA0C4;"><?= h(t('common.back_to_ftc')) ?></a></div>
      <div style="display:inline-block; color:#0066CC; background:#fff; font-weight:700; font-size:11.5px; padding:5px 14px; border-radius:980px; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:18px;"><?= h($team['status_label']) ?></div>
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;">FTC — <?= h($team['name']) ?></h1>
      <?php render_team_description($team, 'p', 'font-size:16.5px; color:#A9B6D6; max-width:640px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section style="padding:64px 28px 56px; max-width:1180px; margin:0 auto;">
    <?php if (is_edit_mode()): ?>
    <div style="margin-bottom:32px; display:flex; gap:10px; flex-wrap:wrap;">
      <button class="rl-btn-add" data-action="edit-team-info" data-id="<?= (int)$team['id'] ?>" data-name="<?= h($team['name']) ?>" data-status="<?= h($team['status_label']) ?>" data-description="<?= h($team['description']) ?>" data-description-en="<?= h($team['description_en'] ?? '') ?>">✎ Modifier nom / statut / description</button>
      <button class="rl-btn" style="background:#FCE8E8; color:#D62828;" data-action="delete-team" data-id="<?= (int)$team['id'] ?>">Supprimer cette équipe</button>
    </div>
    <?php endif; ?>

    <div class="rl-g2" style="grid-template-columns:1fr 1fr; gap:40px; margin-bottom:56px;">
      <div>
        <h2 style="font-weight:700; font-size:19px; color:#1D1D1F; margin:0 0 16px; letter-spacing:-0.01em;"><?= h(t('robot.palmares')) ?></h2>
        <div style="border:1px solid #D2D2D7; border-radius:16px; padding:24px;">
          <?php edit_text('team.' . $team['id'] . '.palmares', "Palmarès à compléter par l'équipe — résultats de compétitions, prix et qualifications à venir.", 'p', 'font-size:14.5px; color:#6E6E73; line-height:1.65; margin:0;'); ?>
        </div>
      </div>
      <div>
        <h2 style="font-weight:700; font-size:19px; color:#1D1D1F; margin:0 0 16px; letter-spacing:-0.01em;"><?= h(t('robot.section')) ?></h2>
        <div style="border:1px solid #D2D2D7; border-radius:16px; padding:24px;">
          <?php edit_text('team.' . $team['id'] . '.robot_desc', "Nom et description du robot à compléter par l'équipe — ce qu'il fait, son mécanisme, sa stratégie de jeu.", 'p', 'font-size:14.5px; color:#6E6E73; line-height:1.65; margin:0 0 14px;'); ?>
          <div style="margin-bottom:18px; font-size:13.5px; color:#6E6E73;">
            <?= h(t('robot.weight')) ?> : <?php edit_text('team.' . $team['id'] . '.weight', 'À compléter', 'span', 'font-weight:700; color:#1D1D1F;'); ?>
          </div>
          <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:14px;">
            <?php render_editable_link('team.' . $team['id'] . '.code', t('robot.code'), '#', 'display:inline-flex; align-items:center; gap:8px; border:1px solid #D2D2D7; color:#1D1D1F; font-weight:600; font-size:12.5px; padding:9px 18px; border-radius:980px;'); ?>
          </div>
          <?php render_model_viewer('team.' . $team['id'], t('robot.model'), '#', 'display:inline-flex; align-items:center; gap:8px; border:1px solid #D2D2D7; color:#1D1D1F; font-weight:600; font-size:12.5px; padding:9px 18px; border-radius:980px;'); ?>
        </div>
      </div>
    </div>

    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; flex-wrap:wrap;">
      <h2 style="font-weight:700; font-size:19px; color:#1D1D1F; margin:0; letter-spacing:-0.01em;"><?= h(t('robot.team')) ?></h2>
      <?php if (is_edit_mode()): ?><button class="rl-btn-add" data-action="add-member" data-team-id="<?= (int)$team['id'] ?>"><?= h(t('robot.add_member')) ?></button><?php endif; ?>
    </div>
    <div class="rl-g4" style="grid-template-columns:repeat(4,1fr); gap:16px;">
      <?php foreach ($members as $m): ?>
      <div style="background:#F5F5F7; border-radius:14px; padding:18px; text-align:center; position:relative;">
        <?php if (is_edit_mode()): ?><button class="rl-delete-x" data-action="delete-member" data-id="<?= (int)$m['id'] ?>">×</button><?php endif; ?>
        <div style="width:56px; height:56px; border-radius:50%; overflow:hidden; margin:0 auto 12px; background:#fff; display:flex; align-items:center; justify-content:center;">
          <?php if ($m['photo_path']): ?>
            <img src="<?= h(UPLOADS_URL . '/' . $m['photo_path']) ?>" alt="Photo de <?= h($m['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
          <?php else: ?>
            <span style="color:#9AA0A6; font-size:9px;"><?= h(t('media.photo_placeholder')) ?></span>
          <?php endif; ?>
        </div>
        <?php edit_text('member.' . $m['id'] . '.name', $m['name'], 'div', 'font-weight:700; font-size:13px; color:#1D1D1F; margin-bottom:3px;'); ?>
        <?php edit_text('member.' . $m['id'] . '.role', $m['role'], 'div', 'font-size:11.5px; color:#6E6E73;'); ?>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
