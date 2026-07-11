<?php
require_once __DIR__ . '/../db.php';

function h(?string $s): string {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

/** Lien de changement de langue qui conserve la page courante et ses paramètres (ex : ?slug=...). */
function lang_url(string $lang): string {
    return '?' . http_build_query(array_merge($_GET, ['lang' => $lang]));
}

/** Valeur texte éditable stockée en base, avec valeur par défaut si absente. */
function text(string $key, string $default): string {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        foreach (db()->query('SELECT block_key, value FROM content_blocks') as $row) {
            $cache[$row['block_key']] = $row['value'];
        }
    }
    return $cache[$key] ?? $default;
}

/**
 * Affiche un bloc de texte éditable en mode admin (double-clic pour modifier).
 * $tag: balise HTML (span, h1, p, ...). $default: texte si aucune valeur enregistrée.
 * En anglais, édite automatiquement la variante "{$key}.en" — si elle est vide,
 * la version française s'affiche à la place (jamais de champ vide côté visiteur).
 */
function edit_text(string $key, string $default, string $tag = 'span', string $style = ''): void {
    if (current_lang() === 'en') {
        $enValue = text($key . '.en', '');
        $value = $enValue !== '' ? $enValue : text($key, $default);
        $storageKey = $key . '.en';
    } else {
        $value = text($key, $default);
        $storageKey = $key;
    }
    $styleAttr = $style !== '' ? ' style="' . h($style) . '"' : '';
    echo "<$tag data-edit-key=\"" . h($storageKey) . "\" class=\"rl-editable\"$styleAttr>" . h($value) . "</$tag>";
}

/** Récupère un média (image/vidéo/modèle 3D) éditable : ['kind'=>..., 'src'=>...] ou null si vide. */
function media(string $key): ?array {
    $stmt = db()->prepare('SELECT kind, path, embed_url FROM media WHERE slot_key = ?');
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    if (!$row) return null;
    if ($row['kind'] === 'embed') {
        return ['kind' => 'embed', 'src' => $row['embed_url']];
    }
    if ($row['kind'] === 'model' && !$row['path'] && $row['embed_url']) {
        // Modèle 3D référencé par URL externe (pas de fichier envoyé sur ce serveur).
        return ['kind' => 'model', 'src' => $row['embed_url']];
    }
    return ['kind' => $row['kind'], 'src' => UPLOADS_URL . '/' . $row['path']];
}

function youtube_embed_url(string $url): ?string {
    if (preg_match('~youtu\.be/([A-Za-z0-9_-]+)~', $url, $m) || preg_match('~youtube\.com/watch\?v=([A-Za-z0-9_-]+)~', $url, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }
    if (preg_match('~vimeo\.com/(\d+)~', $url, $m)) {
        return 'https://player.vimeo.com/video/' . $m[1];
    }
    return null;
}

/**
 * Affiche une zone image/vidéo éditable en mode admin (double-clic pour changer).
 * $imgStyle s'applique à l'<img>/<video>/<iframe> ; $wrapStyle au conteneur.
 */
function render_media(string $key, string $placeholder = 'Glissez une photo ou vidéo ici', string $imgStyle = '', string $wrapStyle = '', ?string $defaultImageSrc = null, string $alt = ''): void {
    $m = media($key);
    $edit = is_edit_mode();
    $altText = $alt !== '' ? $alt : $placeholder;
    $class = 'rl-media-slot' . ($edit ? ' rl-media' : '');
    echo '<div class="' . $class . '"' . ($edit ? ' data-media-key="' . h($key) . '"' : '') . ' style="position:relative; width:100%; height:100%; background:#F5F5F7; display:flex; align-items:center; justify-content:center; overflow:hidden;' . h($wrapStyle) . '">';
    if (!$m) {
        if ($defaultImageSrc !== null) {
            echo '<img src="' . h($defaultImageSrc) . '" alt="' . h($altText) . '" style="width:100%; height:100%; object-fit:cover;' . h($imgStyle) . '">';
        } else {
            echo '<span style="color:#9AA0A6; font-size:12.5px; text-align:center; padding:12px;">' . h($placeholder) . '</span>';
        }
    } elseif ($m['kind'] === 'video') {
        echo '<video src="' . h($m['src']) . '" controls aria-label="' . h($altText) . '" style="width:100%; height:100%; object-fit:cover;' . h($imgStyle) . '"></video>';
    } elseif ($m['kind'] === 'embed') {
        $embed = youtube_embed_url($m['src']) ?? $m['src'];
        echo '<iframe src="' . h($embed) . '" title="' . h($altText) . '" style="width:100%; height:100%; border:0;" allowfullscreen></iframe>';
    } else {
        echo '<img src="' . h($m['src']) . '" alt="' . h($altText) . '" style="width:100%; height:100%; object-fit:cover;' . h($imgStyle) . '">';
    }
    echo '</div>';
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_check(): void {
    $sent = $_POST['csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], (string)$sent)) {
        http_response_code(403);
        echo json_encode(['error' => 'Session invalide, rechargez la page.']);
        exit;
    }
}

function json_input(): array {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

/**
 * Affiche un lien dont le texte ET l'URL sont éditables (double-clic sur le texte,
 * petit bouton 🔗 en mode admin pour changer l'adresse).
 */
function render_editable_link(string $key, string $labelDefault, string $urlDefault, string $linkStyle = ''): void {
    $url = text($key . '.url', $urlDefault);
    echo '<span style="display:inline-flex; align-items:center; gap:6px;">';
    echo '<a href="' . h($url) . '" style="' . h($linkStyle) . '">';
    edit_text($key . '.label', $labelDefault, 'span');
    echo '</a>';
    if (is_edit_mode()) {
        echo '<button data-action="edit-link" data-key="' . h($key . '.url') . '" data-current="' . h($url) . '" title="Modifier le lien" style="border:none; background:#F0F0F2; color:#1D1D1F; width:22px; height:22px; border-radius:50%; font-size:11px; cursor:pointer; line-height:1;">🔗</button>';
    }
    echo '</span>';
}

/**
 * Fiche robot : visualiseur 3D interactif (model-viewer) si un fichier .glb/.gltf a été
 * renseigné pour cette clé, sinon simple lien externe éditable (comportement historique).
 * $key sert de base : le média 3D est stocké sous "$key.model3d", le lien externe sous "$key.cad".
 */
function render_model_viewer(string $key, string $linkLabelDefault, string $linkUrlDefault = '#', string $linkStyle = ''): void {
    $modelKey = $key . '.model3d';
    $m = media($modelKey);
    $edit = is_edit_mode();
    if ($m && $m['kind'] === 'model') {
        echo '<div class="rl-model-viewer" style="position:relative; border-radius:16px; overflow:hidden; background:#F5F5F7; aspect-ratio:4/3;">';
        echo '<model-viewer src="' . h($m['src']) . '" camera-controls auto-rotate shadow-intensity="1" loading="lazy" style="width:100%; height:100%; --poster-color:#F5F5F7;"></model-viewer>';
        echo '<div class="rl-model-loading" data-model-loading>' . h(t('common.loading')) . '</div>';
        echo '</div>';
        if ($edit) {
            echo '<div style="margin-top:10px;"><button class="rl-btn-add" data-action="upload-model" data-key="' . h($modelKey) . '">' . h(t('robot.replace_model')) . '</button></div>';
        }
    } else {
        render_editable_link($key . '.cad', $linkLabelDefault, $linkUrlDefault, $linkStyle);
        if ($edit) {
            echo '<div style="margin-top:8px;"><button class="rl-btn-add" data-action="upload-model" data-key="' . h($modelKey) . '">' . h(t('robot.add_model')) . '</button></div>';
        }
    }
}

/** Icône réseau social ronde dont le lien est éditable (bouton 🔗 en mode admin). */
function render_social_icon(string $key, string $label, string $abbrev): void {
    $url = text('social.' . $key . '.url', '#');
    echo '<span style="display:inline-flex; align-items:center; gap:4px;">';
    echo '<a href="' . h($url) . '" target="_blank" rel="noopener" aria-label="' . h($label) . '" style="width:30px; height:30px; border-radius:50%; background:#E8E8ED; display:flex; align-items:center; justify-content:center; font-size:11px; color:#1D1D1F; font-weight:600;">' . h($abbrev) . '</a>';
    if (is_edit_mode()) {
        echo '<button data-action="edit-link" data-key="social.' . h($key) . '.url" data-current="' . h($url) . '" title="Modifier le lien ' . h($label) . '" style="border:none; background:#F0F0F2; color:#1D1D1F; width:18px; height:18px; border-radius:50%; font-size:9px; cursor:pointer; line-height:1;">🔗</button>';
    }
    echo '</span>';
}

/** Description d'une équipe dans la langue courante (repli sur le français si l'anglais est vide). */
function team_description(array $team): string {
    if (current_lang() === 'en' && !empty($team['description_en'])) {
        return $team['description_en'];
    }
    return $team['description'] ?? '';
}

/** Badge « N équipe(s) active(s) », dans la langue courante. */
function team_count_label(int $n): string {
    return $n . ' ' . ($n > 1 ? t('team.active_many') : t('team.active_one'));
}

function slugify(string $s): string {
    $s = iconv('UTF-8', 'ASCII//TRANSLIT', $s) ?: $s;
    $s = strtolower(trim($s));
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return trim($s, '-') ?: bin2hex(random_bytes(4));
}

const IMAGE_MIMES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/svg+xml' => 'svg'];
const VIDEO_MIMES = ['video/mp4' => 'mp4', 'video/webm' => 'webm'];
const DOCUMENT_MIMES = ['application/pdf' => 'pdf'];
const MODEL_EXTENSIONS = ['glb', 'gltf'];

/**
 * Enregistre un modèle 3D envoyé (.glb/.gltf). La détection MIME de finfo n'étant pas fiable
 * pour ce format, on valide par extension et par un contrôle léger des premiers octets.
 * Retourne le chemin relatif (à partir de uploads/) ou lève une exception.
 */
function store_model_upload(array $file): string {
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Échec de l'envoi du fichier.");
    }
    if ($file['size'] > MAX_MODEL_UPLOAD_BYTES) {
        throw new RuntimeException('Fichier trop volumineux (' . (int)(MAX_MODEL_UPLOAD_BYTES / 1024 / 1024) . ' Mo maximum).');
    }
    $ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, MODEL_EXTENSIONS, true)) {
        throw new RuntimeException('Format non supporté : utilisez un fichier .glb ou .gltf.');
    }
    $head = file_get_contents($file['tmp_name'], false, null, 0, 4) ?: '';
    if ($ext === 'glb' && $head !== 'glTF') {
        throw new RuntimeException("Ce fichier .glb ne semble pas valide.");
    }
    if ($ext === 'gltf' && trim(substr($head, 0, 1)) !== '{') {
        throw new RuntimeException("Ce fichier .gltf ne semble pas valide.");
    }
    $name = bin2hex(random_bytes(12)) . '.' . $ext;
    $dir = UPLOADS_DIR . '/models';
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $dest = $dir . '/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        throw new RuntimeException("Impossible d'enregistrer le fichier.");
    }
    return 'models/' . $name;
}

/**
 * Affiche un document téléchargeable (PDF) éditable : bouton d'envoi en mode admin,
 * lien de téléchargement sinon. $key sert de clé dans la table media (kind='document').
 */
function render_document(string $key, string $labelDefault): void {
    $stmt = db()->prepare("SELECT path FROM media WHERE slot_key = ? AND kind = 'document'");
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    echo '<div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">';
    if ($row) {
        echo '<a href="' . h(UPLOADS_URL . '/' . $row['path']) . '" target="_blank" rel="noopener" style="display:inline-flex; align-items:center; gap:8px; background:#D62828; color:#fff; font-weight:600; font-size:14.5px; padding:12px 24px; border-radius:980px;">📄 ' . h($labelDefault) . '</a>';
    } elseif (!is_edit_mode()) {
        echo '<span style="color:#9AA0A6; font-size:14px;">Dossier à venir.</span>';
    }
    if (is_edit_mode()) {
        echo '<button class="rl-btn-add" data-action="upload-document" data-key="' . h($key) . '">' . ($row ? '📎 Remplacer le PDF' : '📎 Envoyer le PDF') . '</button>';
    }
    echo '</div>';
}

/**
 * Enregistre un fichier envoyé (upload) dans le sous-dossier donné, après vérification du type réel.
 * Retourne le chemin relatif (à partir de uploads/) ou lève une exception.
 */
function store_upload(array $file, string $subdir, array $allowedMimes): string {
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Échec de l'envoi du fichier.");
    }
    if ($file['size'] > MAX_UPLOAD_BYTES) {
        throw new RuntimeException('Fichier trop volumineux (15 Mo maximum).');
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!isset($allowedMimes[$mime])) {
        throw new RuntimeException('Type de fichier non autorisé.');
    }
    $ext = $allowedMimes[$mime];
    $name = bin2hex(random_bytes(12)) . '.' . $ext;
    $dir = UPLOADS_DIR . '/' . $subdir;
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $dest = $dir . '/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        throw new RuntimeException("Impossible d'enregistrer le fichier.");
    }
    return $subdir . '/' . $name;
}
