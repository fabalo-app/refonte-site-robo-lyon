  <footer style="background:#F5F5F7; color:#6E6E73; padding:48px 28px 24px; border-top:1px solid #D2D2D7;">
    <div style="max-width:1180px; margin:0 auto;">
      <div class="rl-g3" style="grid-template-columns:1.4fr 1fr 1fr; gap:40px; margin-bottom:32px;">
        <div>
          <div style="display:flex; align-items:center; gap:9px; margin-bottom:14px;">
            <img src="assets/img/brand/logo-robolyon-blue.svg" alt="Logo Robo'Lyon" style="height:20px;">
            <span style="font-weight:600; font-size:14px; color:#1D1D1F;">Robo'Lyon</span>
          </div>
          <?php edit_text('footer.about', "Association loi 1901 de robotique de compétition FIRST®, basée à Neuville-sur-Saône. Première équipe française à avoir participé à la FRC.", 'p', 'font-size:13px; line-height:1.6; max-width:320px; margin:0;'); ?>
        </div>
        <div>
          <h4 style="color:#1D1D1F; font-size:13px; font-weight:600; margin:0 0 14px;"><?= h(t('footer.navigation')) ?></h4>
          <div style="display:flex; flex-direction:column; gap:9px; font-size:13px;">
            <a href="association.php" style="color:#6E6E73;"><?= h(t('nav.association')) ?></a>
            <a href="equipes.php" style="color:#6E6E73;"><?= h(t('nav.equipes')) ?></a>
            <a href="actus.php" style="color:#6E6E73;"><?= h(t('nav.actus')) ?></a>
            <a href="sponsors.php" style="color:#6E6E73;"><?= h(t('nav.sponsors')) ?></a>
            <a href="contact.php" style="color:#6E6E73;"><?= h(t('nav.contact')) ?></a>
          </div>
        </div>
        <div>
          <h4 style="color:#1D1D1F; font-size:13px; font-weight:600; margin:0 0 14px;"><?= h(t('footer.contact')) ?></h4>
          <div style="font-size:13px; line-height:1.7; margin-bottom:14px;">
            <?php edit_text('footer.address', "22 avenue Gambetta\n69250 Neuville-sur-Saône", 'span', 'white-space:pre-line;'); ?><br>
            <a href="mailto:<?= h(text('footer.email', 'contact@robolyon.com')) ?>" style="color:#6E6E73;"><?= h(text('footer.email', 'contact@robolyon.com')) ?></a>
          </div>
          <div style="font-weight:700; font-size:12px; color:#1D1D1F; margin-bottom:8px;"><?= h(t('footer.follow')) ?></div>
          <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <?php render_social_icon('instagram', 'Instagram', 'IG'); ?>
            <?php render_social_icon('facebook', 'Facebook', 'FB'); ?>
            <?php render_social_icon('youtube', 'YouTube', 'YT'); ?>
            <?php render_social_icon('linkedin', 'LinkedIn', 'in'); ?>
          </div>
        </div>
      </div>
      <div style="border-top:1px solid #D2D2D7; padding-top:16px; display:flex; justify-content:space-between; flex-wrap:wrap; gap:8px; font-size:12px;">
        <span>© <?= date('Y') ?> Robo'Lyon. <?= h(t('footer.rights')) ?></span>
        <a href="<?= is_logged_in() ? 'admin.php' : 'login.php' ?>" style="color:#6E6E73;"><?= is_logged_in() ? h(t('nav.espace_admin')) : h(t('nav.connexion_admin')) ?></a>
      </div>
    </div>
  </footer>

</div>

<?php if (is_logged_in()): ?>
<button id="rl-toggle-edit" style="position:fixed; bottom:18px; right:18px; z-index:300; background:#1D1D1F; color:#fff; border:none; font-family:'Inter',sans-serif; font-weight:500; font-size:12.5px; padding:10px 16px; border-radius:980px; cursor:pointer; box-shadow:0 6px 18px rgba(0,0,0,0.25); display:flex; align-items:center; gap:8px;">
  <span><?= is_edit_mode() ? h(t('admin.disable_edit')) : h(t('admin.enable_edit')) ?></span>
</button>
<div id="rl-toast" class="rl-admin-toast"></div>
<?php else: ?>
<a href="login.php" style="position:fixed; bottom:18px; right:18px; z-index:300; background:#1D1D1F; color:#fff; font-family:'Inter',sans-serif; font-weight:500; font-size:12.5px; padding:10px 16px; border-radius:980px; box-shadow:0 6px 18px rgba(0,0,0,0.25); display:flex; align-items:center; gap:8px;"><?= h(t('nav.connexion_admin')) ?></a>
<?php endif; ?>

<script>
window.RL_CSRF = <?= json_encode(csrf_token()) ?>;
window.RL_EDIT_MODE = <?= is_edit_mode() ? 'true' : 'false' ?>;
window.RL_T = <?= json_encode($GLOBALS['RL_I18N'][current_lang()]) ?>;
</script>
<script src="assets/js/editable.js"></script>
</body>
</html>
