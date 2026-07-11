<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$data = json_input();
$id = (int)($data['id'] ?? 0);
db()->prepare('DELETE FROM mentors WHERE id = ?')->execute([$id]);

echo json_encode(['ok' => true]);
