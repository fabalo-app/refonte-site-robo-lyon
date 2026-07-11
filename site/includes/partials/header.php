<?php
/** Attend $activePage (accueil|association|equipes|actus|sponsors|contact) défini avant l'inclusion. */
$active = $activePage ?? '';
function nav_link(string $href, string $label, bool $active): void {
    $style = $active
        ? 'font-weight:600; font-size:13px; color:#fff; border-bottom:2px solid #D62828; padding-bottom:20px;'
        : 'font-weight:400; font-size:13px; color:#C7D2E8;';
    echo '<a href="' . h($href) . '" style="' . $style . '">' . h($label) . '</a>';
}
?>
<div style="background:#0B1F3A;">
  <?php if (is_logged_in()): ?>
  <div style="background:#1D1D1F; color:#fff; display:flex; align-items:center; justify-content:space-between; gap:12px; padding:9px 24px; font-size:12.5px; flex-wrap:wrap;">
    <span><?= is_edit_mode() ? h(t('admin.mode_active')) : h(t('admin.logged_as')) . ' ' . h(current_admin()['email']) ?></span>
    <a href="admin.php" style="color:#FF8A8A;"><?= h(t('nav.espace_admin')) ?> →</a>
  </div>
  <?php endif; ?>
  <?php $frcTeam = db()->query("SELECT name FROM teams WHERE program='FRC' LIMIT 1")->fetch(); ?>
  <header style="max-width:1180px; margin:0 auto; padding:0 28px; height:60px; display:flex; align-items:center; justify-content:space-between; gap:24px;">
    <a href="index.php" style="display:flex; align-items:center; gap:9px;">
      <img src="assets/img/brand/logo-robolyon-blue.svg" alt="Logo Robo'Lyon" style="height:22px; width:auto; filter:brightness(0) invert(1);">
      <span style="font-weight:600; font-size:14.5px; letter-spacing:-0.01em; color:#fff;">Robo'Lyon</span>
    </a>
    <nav class="rl-nav-desktop" style="display:flex; align-items:center; gap:30px;">
      <?php nav_link('index.php', t('nav.accueil'), $active === 'accueil'); ?>
      <div data-dd style="position:relative; padding:8px 0;">
        <a href="association.php" style="display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:<?= $active === 'association' ? '600' : '400' ?>; font-size:13px; color:<?= $active === 'association' ? '#fff' : '#C7D2E8' ?>;"><?= h(t('nav.association')) ?><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
        <div data-dd-line style="position:absolute; left:0; right:0; bottom:0; height:2px; background:#D62828; opacity:<?= $active === 'association' ? '1' : '0' ?>; transition:opacity .15s;"></div>
        <div data-dd-panel style="position:absolute; top:100%; left:50%; transform:translateX(-50%) translateY(4px); background:#fff; border-radius:12px; box-shadow:0 20px 44px rgba(11,31,58,0.18); padding:8px; min-width:190px; z-index:50; opacity:0; visibility:hidden; transition:opacity .15s, transform .15s;">
          <a href="association.php#histoire" style="display:block; padding:11px 16px; border-radius:8px; font-weight:500; font-size:14px; color:#0B1F3A;"><?= h(t('nav.histoire')) ?></a>
          <a href="association.php#mentors" style="display:block; padding:11px 16px; border-radius:8px; font-weight:500; font-size:14px; color:#0B1F3A;"><?= h(t('nav.mentors')) ?></a>
          <a href="association.php#activites" style="display:block; padding:11px 16px; border-radius:8px; font-weight:500; font-size:14px; color:#0B1F3A;"><?= h(t('nav.activites')) ?></a>
          <a href="association.php#valeurs" style="display:block; padding:11px 16px; border-radius:8px; font-weight:500; font-size:14px; color:#0B1F3A;"><?= h(t('nav.valeurs')) ?></a>
          <a href="association.php#missions" style="display:block; padding:11px 16px; border-radius:8px; font-weight:500; font-size:14px; color:#0B1F3A;"><?= h(t('nav.missions')) ?></a>
        </div>
      </div>
      <div data-dd style="position:relative; padding:8px 0;">
        <a href="equipes.php" style="display:flex; align-items:center; gap:5px; cursor:pointer; font-weight:<?= $active === 'equipes' ? '600' : '400' ?>; font-size:13px; color:<?= $active === 'equipes' ? '#fff' : '#C7D2E8' ?>;"><?= h(t('nav.equipes')) ?><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
        <div data-dd-line style="position:absolute; left:0; right:0; bottom:0; height:2px; background:#D62828; opacity:<?= $active === 'equipes' ? '1' : '0' ?>; transition:opacity .15s;"></div>
        <div data-dd-panel style="position:absolute; top:100%; left:50%; transform:translateX(-50%) translateY(4px); background:#fff; border-radius:12px; box-shadow:0 20px 44px rgba(11,31,58,0.18); padding:8px; min-width:200px; z-index:50; opacity:0; visibility:hidden; transition:opacity .15s, transform .15s;">
          <a href="frc.php" style="display:block; padding:11px 16px; border-radius:8px; font-weight:500; font-size:14px; color:#0B1F3A;">FRC — <?= h($frcTeam['name'] ?? '') ?></a>
          <a href="ftc.php" style="display:block; padding:11px 16px; border-radius:8px; font-weight:500; font-size:14px; color:#0B1F3A;"><?= h(t('nav.ftc_all')) ?></a>
        </div>
      </div>
      <?php nav_link('actus.php', t('nav.actus'), $active === 'actus'); ?>
      <?php nav_link('sponsors.php', t('nav.sponsors'), $active === 'sponsors'); ?>
      <?php nav_link('contact.php', t('nav.contact'), $active === 'contact'); ?>
      <?php if (is_logged_in()): ?>
        <a href="admin.php" style="font-weight:600; font-size:13px; color:#FF8A8A;"><?= h(t('nav.espace_admin')) ?></a>
      <?php endif; ?>
      <div class="rl-lang-switch">
        <a href="<?= h(lang_url('fr')) ?>" class="<?= current_lang() === 'fr' ? 'rl-lang-active' : '' ?>">FR</a>
        <span>/</span>
        <a href="<?= h(lang_url('en')) ?>" class="<?= current_lang() === 'en' ? 'rl-lang-active' : '' ?>">EN</a>
      </div>
    </nav>
    <div style="display:flex; align-items:center; gap:10px;">
      <a href="soutenir.php" style="background:#fff; color:#0B1F3A; font-weight:600; font-size:12.5px; padding:8px 18px; border-radius:980px; white-space:nowrap;"><?php edit_text('nav.cta_label', 'Nous soutenir', 'span'); ?></a>
      <button id="rl-nav-toggle" class="rl-nav-toggle" aria-label="<?= h(t('nav.menu')) ?>" aria-expanded="false">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
      </button>
    </div>
  </header>
  <div id="rl-nav-mobile" class="rl-nav-mobile">
    <a href="index.php"><?= h(t('nav.accueil')) ?></a>
    <a href="association.php"><?= h(t('nav.association')) ?></a>
    <a href="equipes.php"><?= h(t('nav.equipes')) ?></a>
    <a href="actus.php"><?= h(t('nav.actus')) ?></a>
    <a href="sponsors.php"><?= h(t('nav.sponsors')) ?></a>
    <a href="contact.php"><?= h(t('nav.contact')) ?></a>
    <a href="soutenir.php" style="color:#FF8A8A;"><?= h(text('nav.cta_label', 'Nous soutenir')) ?></a>
    <?php if (is_logged_in()): ?><a href="admin.php" style="color:#FF8A8A;"><?= h(t('nav.espace_admin')) ?></a><?php endif; ?>
    <div style="padding:14px 28px;">
      <div class="rl-lang-switch">
        <a href="<?= h(lang_url('fr')) ?>" class="<?= current_lang() === 'fr' ? 'rl-lang-active' : '' ?>">FR</a>
        <span>/</span>
        <a href="<?= h(lang_url('en')) ?>" class="<?= current_lang() === 'en' ? 'rl-lang-active' : '' ?>">EN</a>
      </div>
    </div>
  </div>
