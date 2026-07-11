<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$data = json_input();
$id = (int)($data['id'] ?? 0);
$stmt = db()->prepare('DELETE FROM team_members WHERE id = ?');
$stmt->execute([$id]);

echo json_encode(['ok' => true]);
