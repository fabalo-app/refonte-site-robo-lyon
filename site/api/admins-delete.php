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
// Il doit toujours rester au moins un propriétaire.
if ($row['role'] === 'owner') {
    $countStmt = db()->prepare("SELECT COUNT(*) c FROM admins WHERE role = 'owner' AND id != ?");
    $countStmt->execute([$id]);
    if ((int) $countStmt->fetch()['c'] === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Impossible : il doit toujours rester au moins un propriétaire.']);
        exit;
    }
}

db()->prepare('DELETE FROM admins WHERE id = ?')->execute([$id]);
echo json_encode(['ok' => true]);
