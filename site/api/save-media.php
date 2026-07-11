<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$key = trim((string)($_POST['key'] ?? ''));
if ($key === '' || !preg_match('/^[a-z0-9_.\-]+$/i', $key)) {
    http_response_code(400);
    echo json_encode(['error' => 'Clé invalide.']);
    exit;
}

try {
    if (!empty($_POST['embed_url'])) {
        $url = trim((string)$_POST['embed_url']);
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Lien vidéo invalide.');
        }
        $stmt = db()->prepare('INSERT INTO media (slot_key, kind, path, embed_url) VALUES (?, "embed", NULL, ?)
            ON DUPLICATE KEY UPDATE kind = "embed", path = NULL, embed_url = VALUES(embed_url)');
        $stmt->execute([$key, $url]);
    } elseif (!empty($_FILES['file'])) {
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES['file']['tmp_name']);
        if (isset(VIDEO_MIMES[$mime])) {
            $path = store_upload($_FILES['file'], 'media', VIDEO_MIMES);
            $kind = 'video';
        } else {
            $path = store_upload($_FILES['file'], 'media', IMAGE_MIMES);
            $kind = 'image';
        }
        $stmt = db()->prepare('INSERT INTO media (slot_key, kind, path, embed_url) VALUES (?, ?, ?, NULL)
            ON DUPLICATE KEY UPDATE kind = VALUES(kind), path = VALUES(path), embed_url = NULL');
        $stmt->execute([$key, $kind, $path]);
    } else {
        throw new RuntimeException('Aucun fichier ni lien fourni.');
    }
} catch (RuntimeException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

echo json_encode(['ok' => true]);
