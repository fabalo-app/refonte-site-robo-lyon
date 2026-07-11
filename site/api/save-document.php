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
if (empty($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Aucun fichier fourni.']);
    exit;
}

try {
    $path = store_upload($_FILES['file'], 'documents', DOCUMENT_MIMES);
} catch (RuntimeException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$stmt = db()->prepare('INSERT INTO media (slot_key, kind, path, embed_url) VALUES (?, "document", ?, NULL)
    ON DUPLICATE KEY UPDATE kind = "document", path = VALUES(path), embed_url = NULL');
$stmt->execute([$key, $path]);

echo json_encode(['ok' => true]);
