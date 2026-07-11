<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$teamId = (int)($_POST['team_id'] ?? 0);
$name = trim((string)($_POST['name'] ?? ''));
$role = trim((string)($_POST['role'] ?? ''));

if ($name === '' || $role === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Nom et rôle requis.']);
    exit;
}

$check = db()->prepare('SELECT id FROM teams WHERE id = ?');
$check->execute([$teamId]);
if (!$check->fetch()) {
    http_response_code(404);
    echo json_encode(['error' => 'Équipe introuvable.']);
    exit;
}

$photoPath = null;
if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    try {
        $photoPath = store_upload($_FILES['photo'], 'teams', IMAGE_MIMES);
    } catch (RuntimeException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

$stmt2 = db()->prepare('SELECT COALESCE(MAX(sort_order),0) m FROM team_members WHERE team_id = ?');
$stmt2->execute([$teamId]);
$maxOrder = (int)$stmt2->fetch()['m'];

$stmt = db()->prepare('INSERT INTO team_members (team_id, name, role, photo_path, sort_order) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$teamId, $name, $role, $photoPath, $maxOrder + 1]);

echo json_encode(['ok' => true, 'id' => db()->lastInsertId()]);
