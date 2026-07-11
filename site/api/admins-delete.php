<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_owner_json();
csrf_check();

$data = json_input();
$id = (int)($data['id'] ?? 0);

$stmt = db()->prepare('SELECT role FROM admins WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) {
    http_response_code(404);
    echo json_encode(['error' => 'Administrateur introuvable.']);
    exit;
}
if ($row['role'] === 'owner') {
    http_response_code(400);
    echo json_encode(['error' => 'Impossible de retirer un propriétaire.']);
    exit;
}

db()->prepare('DELETE FROM admins WHERE id = ?')->execute([$id]);
echo json_encode(['ok' => true]);
