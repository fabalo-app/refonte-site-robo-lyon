<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = t('title.soutenir');
$activePage = '';
require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 64px; text-align:center;">
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;"><?= h(t('page.soutenir.title')) ?></h1>
      <?php edit_text('soutenir.hero_subtitle', "Don, mentorat ou sponsoring : chaque geste aide nos équipes à concevoir, construire et concourir chaque saison.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:600px; margin:0 auto; line-height:1.55;'); ?>
      <div class="rl-stack-mobile" style="display:flex; gap:24px; justify-content:center; margin-top:28px; flex-wrap:wrap;">
        <a href="#don" style="color:#fff; font-weight:600; font-size:13.5px; border-bottom:2px solid #D62828; padding-bottom:4px;"><?= h(t('soutenir.jump_don')) ?></a>
        <a href="#mentor" style="color:#C7D2E8; font-weight:500; font-size:13.5px;"><?= h(t('soutenir.jump_mentor')) ?></a>
        <a href="#sponsor" style="color:#C7D2E8; font-weight:500; font-size:13.5px;"><?= h(t('soutenir.jump_sponsor')) ?></a>
      </div>
    </section>
  </div>

  <section id="don" style="padding:72px 28px; max-width:1180px; margin:0 auto;">
    <div class="rl-g2" style="grid-template-columns:1fr 1fr; gap:48px; align-items:center;">
      <div>
        <?php edit_text('soutenir.don_eyebrow', 'Don en ligne', 'span', 'display:inline-block; color:#D62828; font-weight:700; font-size:12px; letter-spacing:0.03em; margin-bottom:16px; text-transform:uppercase;'); ?>
        <?php edit_text('soutenir.don_title', "Faire un don à l'association", 'h2', 'font-weight:700; font-size:26px; color:#1D1D1F; margin:0 0 14px; letter-spacing:-0.015em; display:block;'); ?>
        <?php edit_text('soutenir.don_desc', "Robo'Lyon est une association loi 1901. Votre don, ponctuel ou régulier, finance directement le matériel de compétition, les déplacements et l'accueil de nouveaux élèves. La collecte est gérée via HelloAsso, sans frais pour l'association.", 'p', 'color:#6E6E73; font-size:15.5px; line-height:1.7; margin:0 0 24px;'); ?>
        <?php render_editable_link('soutenir.helloasso', 'Faire un don via HelloAsso →', '#', 'display:inline-block; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px 26px; border-radius:980px;'); ?>
      </div>
      <div style="border:1px solid #D2D2D7; border-radius:16px; padding:28px;">
        <?php
        $tiers = [
          ['key' => 'soutenir.tier1', 'label' => 'Un capteur, un actionneur', 'amount' => '30 €'],
          ['key' => 'soutenir.tier2', 'label' => 'Un déplacement en compétition', 'amount' => '100 €'],
          ['key' => 'soutenir.tier3', 'label' => 'Le matériel d\'une saison complète', 'amount' => '500 €'],
        ];
        foreach ($tiers as $i => $t):
        ?>
        <div style="display:flex; justify-content:space-between; padding:14px 0; <?= $i < 2 ? 'border-bottom:1px solid #D2D2D7;' : '' ?>">
          <?php edit_text($t['key'] . '.label', $t['label'], 'span', 'color:#6E6E73; font-size:14px;'); ?>
          <?php edit_text($t['key'] . '.amount', $t['amount'], 'span', 'font-weight:700; color:#1D1D1F;'); ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="mentor" style="background:#F5F5F7; padding:72px 28px;">
    <div class="rl-g2" style="max-width:1180px; margin:0 auto; grid-template-columns:1fr 1fr; gap:48px; align-items:center;">
      <div style="order:2;">
        <?php edit_text('soutenir.mentor_eyebrow', 'Bénévolat & mentorat', 'span', 'display:inline-block; color:#0066CC; font-weight:700; font-size:12px; letter-spacing:0.03em; margin-bottom:16px; text-transform:uppercase;'); ?>
        <?php edit_text('soutenir.mentor_title', 'Devenir mentor ou bénévole', 'h2', 'font-weight:700; font-size:26px; color:#1D1D1F; margin:0 0 14px; letter-spacing:-0.015em; display:block;'); ?>
        <?php edit_text('soutenir.mentor_desc', "Parents, enseignants, ingénieurs, anciens élèves : nos mentors accompagnent les jeunes en mécanique, électronique, programmation ou communication. Quelques heures par semaine suffisent pour faire la différence.", 'p', 'color:#6E6E73; font-size:15.5px; line-height:1.7; margin:0 0 24px;'); ?>
        <a href="contact.php" style="display:inline-block; background:#0B1F3A; color:#fff; font-weight:600; font-size:14.5px; padding:12px 26px; border-radius:980px;"><?php edit_text('soutenir.mentor_cta', 'Je veux devenir mentor →', 'span'); ?></a>
      </div>
      <div class="rl-g2" style="order:1; grid-template-columns:1fr 1fr; gap:1px; background:#D2D2D7; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden;">
        <?php
        $roles = [
          ['key' => 'soutenir.role1', 'title' => 'Technique', 'desc' => 'Mécanique, électronique, CAO, programmation'],
          ['key' => 'soutenir.role2', 'title' => 'Communication', 'desc' => 'Réseaux sociaux, sponsoring, événementiel'],
          ['key' => 'soutenir.role3', 'title' => 'Gestion', 'desc' => 'Administratif, logistique, budget'],
          ['key' => 'soutenir.role4', 'title' => 'Encadrement', 'desc' => "Suivi pédagogique, esprit d'équipe"],
        ];
        foreach ($roles as $r):
        ?>
        <div style="background:#fff; padding:20px;">
          <?php edit_text($r['key'] . '.title', $r['title'], 'div', 'font-weight:700; font-size:14px; color:#1D1D1F; margin-bottom:6px;'); ?>
          <?php edit_text($r['key'] . '.desc', $r['desc'], 'div', 'color:#6E6E73; font-size:13px; line-height:1.5;'); ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="sponsor" style="padding:72px 28px; max-width:1180px; margin:0 auto;">
    <div class="rl-stack-mobile" style="background:#0B1F3A; border-radius:20px; padding:52px; display:flex; align-items:center; justify-content:space-between; gap:32px; flex-wrap:wrap;">
      <div style="max-width:600px;">
        <?php edit_text('soutenir.sponsor_eyebrow', 'Sponsoring', 'span', 'display:inline-block; color:#9FC4FF; font-weight:700; font-size:12px; letter-spacing:0.03em; margin-bottom:16px; text-transform:uppercase;'); ?>
        <?php edit_text('soutenir.sponsor_title', 'Devenir sponsor de Robo\'Lyon', 'h2', 'font-weight:700; font-size:24px; color:#fff; margin:0 0 12px; letter-spacing:-0.01em; display:block;'); ?>
        <?php edit_text('soutenir.sponsor_desc', "Ressources techniques, mécénat financier ou visibilité lors de nos compétitions : découvrez comment votre entreprise peut soutenir la relève scientifique lyonnaise.", 'p', 'color:#A9B6D6; font-size:15.5px; line-height:1.7; margin:0;'); ?>
      </div>
      <a href="sponsors.php" style="background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:13px 26px; border-radius:980px; white-space:nowrap;"><?php edit_text('soutenir.sponsor_cta', 'Voir la page Sponsors →', 'span'); ?></a>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
