<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
$admin = require_login_json();
csrf_check();

$data = json_input();
$current = (string)($data['current_password'] ?? '');
$new = (string)($data['new_password'] ?? '');

$stmt = db()->prepare('SELECT password_hash FROM admins WHERE id = ?');
$stmt->execute([$admin['id']]);
$row = $stmt->fetch();

if (!$row || !password_verify($current, $row['password_hash'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Mot de passe actuel incorrect.']);
    exit;
}
if (strlen($new) < 8) {
    http_response_code(400);
    echo json_encode(['error' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.']);
    exit;
}

db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?')
    ->execute([password_hash($new, PASSWORD_DEFAULT), $admin['id']]);

echo json_encode(['ok' => true]);
