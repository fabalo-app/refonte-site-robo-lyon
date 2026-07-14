<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = t('title.contact');
$activePage = 'contact';

$sent = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (!empty($_POST['website'])) {
        // Piège à robots (honeypot) : on fait semblant d'avoir réussi.
        $sent = true;
    } else {
        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $subject = trim((string)($_POST['subject'] ?? ''));
        $message = trim((string)($_POST['message'] ?? ''));

        if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = t('page.contact.error');
        } else {
            $stmt = db()->prepare('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $email, $subject ?: '(sans sujet)', $message]);

            $to = text('footer.email', 'contact@robolyon.com');
            $body = "Nom : $name\nE-mail : $email\nSujet : $subject\n\n$message";
            $headers = "From: \"Formulaire Robo'Lyon\" <no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'robolyon.com') . ">\r\nReply-To: $email\r\n";
            @mail($to, "[Robo'Lyon] " . ($subject ?: 'Nouveau message'), $body, $headers);

            $sent = true;
        }
    }
}

require __DIR__ . '/includes/partials/head.php';
?>
<div style="font-family:'Inter',-apple-system,sans-serif; background:#FFFFFF;">

<?php require __DIR__ . '/includes/partials/header.php'; ?>

    <section style="padding:56px 28px 64px; text-align:center;">
      <h1 style="font-weight:700; font-size:clamp(32px,4vw,46px); letter-spacing:-0.02em; color:#fff; margin:0 0 14px;"><?= h(t('page.contact.title')) ?></h1>
      <?php edit_text('contact.hero_subtitle', "Une question, un projet de sponsoring, une envie de rejoindre l'équipe ? Écrivez-nous.", 'p', 'font-size:16.5px; color:#A9B6D6; max-width:600px; margin:0 auto; line-height:1.55;'); ?>
    </section>
  </div>

  <section class="rl-g2" style="padding:64px 28px 96px; max-width:1080px; margin:0 auto; grid-template-columns:1.2fr 1fr; gap:56px; align-items:start;">
    <div>
      <?php if ($sent): ?>
        <div style="border:1px solid #D2D2D7; border-radius:16px; padding:40px; text-align:center;">
          <h2 style="font-weight:700; font-size:19px; margin:0 0 10px;"><?= h(t('page.contact.sent_title')) ?></h2>
          <p style="color:#6E6E73; font-size:14.5px; margin:0;"><?= h(t('page.contact.sent_desc')) ?></p>
        </div>
      <?php else: ?>
      <?php if ($error): ?><div style="background:#FCE8E8; color:#D62828; font-size:13px; font-weight:600; padding:10px 14px; border-radius:8px; margin-bottom:16px;"><?= h($error) ?></div><?php endif; ?>
      <form method="post" style="display:flex; flex-direction:column; gap:18px;">
        <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
        <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute; left:-9999px;" aria-hidden="true">
        <div>
          <label style="display:block; font-weight:600; font-size:13.5px; color:#1D1D1F; margin-bottom:7px;"><?= h(t('page.contact.name')) ?></label>
          <input type="text" name="name" required style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:15px;">
        </div>
        <div>
          <label style="display:block; font-weight:600; font-size:13.5px; color:#1D1D1F; margin-bottom:7px;"><?= h(t('page.contact.email')) ?></label>
          <input type="email" name="email" required style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:15px;">
        </div>
        <div>
          <label style="display:block; font-weight:600; font-size:13.5px; color:#1D1D1F; margin-bottom:7px;"><?= h(t('page.contact.subject')) ?></label>
          <input type="text" name="subject" style="width:100%; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:15px;">
        </div>
        <div>
          <label style="display:block; font-weight:600; font-size:13.5px; color:#1D1D1F; margin-bottom:7px;"><?= h(t('page.contact.message')) ?></label>
          <textarea name="message" required style="width:100%; min-height:130px; padding:11px 14px; border:1px solid #D2D2D7; border-radius:8px; font-size:15px; resize:vertical;"></textarea>
        </div>
        <button type="submit" style="align-self:flex-start; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px 26px; border-radius:980px; border:none; cursor:pointer;"><?= h(t('page.contact.send')) ?></button>
      </form>
      <?php endif; ?>
    </div>

    <div>
      <h2 style="font-weight:700; font-size:20px; color:#1D1D1F; margin:0 0 20px; letter-spacing:-0.01em;"><?= h(t('page.contact.coords')) ?></h2>
      <div style="margin-bottom:20px;">
        <div style="font-weight:700; font-size:13px; margin-bottom:4px;"><?= h(t('page.contact.address')) ?></div>
        <?php edit_text('contact.address', "22 avenue Gambetta\n69250 Neuville-sur-Saône, France", 'div', 'color:#6E6E73; font-size:14px; line-height:1.6; white-space:pre-line;'); ?>
      </div>
      <div style="margin-bottom:20px;">
        <div style="font-weight:700; font-size:13px; margin-bottom:4px;"><?= h(t('page.contact.email')) ?></div>
        <a href="mailto:<?= h(text('footer.email', 'contact@robolyon.com')) ?>" style="font-size:14px;"><?= h(text('footer.email', 'contact@robolyon.com')) ?></a>
      </div>
      <div style="margin-bottom:28px;">
        <div style="font-weight:700; font-size:13px; margin-bottom:4px;"><?= h(t('page.contact.access')) ?></div>
        <?php edit_text('contact.access', "Depuis le centre de Lyon : bus TCL ligne 40. Depuis la gare de Lyon Part-Dieu : suivre les correspondances vers Neuville-sur-Saône.", 'div', 'color:#6E6E73; font-size:14px; line-height:1.6;'); ?>
      </div>
      <div style="aspect-ratio:16/9; border:1px solid #D2D2D7; border-radius:16px; overflow:hidden; margin-bottom:24px;">
        <?php render_media('contact.map_media', t('media.map')); ?>
      </div>
      <div style="font-weight:700; font-size:13px; margin-bottom:10px;"><?= h(t('footer.follow')) ?></div>
      <div style="display:flex; gap:10px; margin-bottom:32px;">
        <?php render_social_icon('instagram', 'Instagram', 'IG'); ?>
        <?php render_social_icon('facebook', 'Facebook', 'FB'); ?>
        <?php render_social_icon('youtube', 'YouTube', 'YT'); ?>
        <?php render_social_icon('linkedin', 'LinkedIn', 'in'); ?>
      </div>

      <div style="border-top:1px solid #D2D2D7; padding-top:24px;">
        <div style="font-weight:700; font-size:13px; margin-bottom:6px;"><?= h(t('footer.newsletter')) ?></div>
        <p style="color:#6E6E73; font-size:13px; line-height:1.6; margin:0 0 12px;"><?= h(t('footer.newsletter_desc')) ?></p>
        <form id="rl-newsletter-form" style="display:flex; gap:8px; flex-wrap:wrap;">
          <input type="email" name="email" required placeholder="vous@exemple.com" style="flex:1; min-width:160px; padding:10px 12px; border:1px solid #D2D2D7; border-radius:8px; font-size:13.5px;">
          <button type="submit" style="background:#0B1F3A; color:#fff; font-weight:600; font-size:13px; padding:10px 18px; border-radius:8px; border:none; cursor:pointer;"><?= h(t('footer.newsletter_button')) ?></button>
        </form>
        <div class="rl-newsletter-msg" style="font-size:12.5px; margin-top:8px;"></div>
      </div>
    </div>
  </section>

<?php require __DIR__ . '/includes/partials/footer.php'; ?>
