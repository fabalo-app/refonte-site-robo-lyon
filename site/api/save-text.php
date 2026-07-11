<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$data = json_input();
$key = trim((string)($data['key'] ?? ''));
$value = trim((string)($data['value'] ?? ''));

if ($key === '' || !preg_match('/^[a-z0-9_.\-]+$/i', $key)) {
    http_response_code(400);
    echo json_encode(['error' => 'Clé invalide.']);
    exit;
}
if (mb_strlen($value) > 20000) {
    http_response_code(400);
    echo json_encode(['error' => 'Texte trop long.']);
    exit;
}

$stmt = db()->prepare('INSERT INTO content_blocks (block_key, value) VALUES (?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)');
$stmt->execute([$key, $value]);

echo json_encode(['ok' => true]);
