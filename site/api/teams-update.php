<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$data = json_input();
$id = (int)($data['id'] ?? 0);
$name = trim((string)($data['name'] ?? ''));
$status = trim((string)($data['status_label'] ?? ''));
$description = trim((string)($data['description'] ?? ''));
$descriptionEn = trim((string)($data['description_en'] ?? ''));

if ($id <= 0 || $name === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Nom requis.']);
    exit;
}

$stmt = db()->prepare('UPDATE teams SET name = ?, status_label = ?, description = ?, description_en = ? WHERE id = ?');
$stmt->execute([$name, $status, $description, $descriptionEn ?: null, $id]);

echo json_encode(['ok' => true]);
