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
    if (!empty($_FILES['file']['name'])) {
        $path = store_model_upload($_FILES['file']);
        $stmt = db()->prepare('INSERT INTO media (slot_key, kind, path, embed_url) VALUES (?, "model", ?, NULL)
            ON DUPLICATE KEY UPDATE kind = "model", path = VALUES(path), embed_url = NULL');
        $stmt->execute([$key, $path]);
    } elseif (!empty($_POST['url'])) {
        $url = trim((string)$_POST['url']);
        if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('/\.(glb|gltf)(\?.*)?$/i', $url)) {
            throw new RuntimeException('Indiquez une URL valide se terminant par .glb ou .gltf.');
        }
        $stmt = db()->prepare('INSERT INTO media (slot_key, kind, path, embed_url) VALUES (?, "model", NULL, ?)
            ON DUPLICATE KEY UPDATE kind = "model", path = NULL, embed_url = VALUES(embed_url)');
        $stmt->execute([$key, $url]);
    } else {
        throw new RuntimeException('Choisissez un fichier .glb/.gltf ou indiquez une URL.');
    }
} catch (RuntimeException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

echo json_encode(['ok' => true]);
