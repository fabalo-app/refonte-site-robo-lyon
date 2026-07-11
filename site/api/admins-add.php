<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_owner_json();
csrf_check();

$data = json_input();
$email = trim((string)($data['email'] ?? ''));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'E-mail invalide.']);
    exit;
}

$existing = db()->prepare('SELECT id FROM admins WHERE email = ?');
$existing->execute([$email]);
if ($existing->fetch()) {
    http_response_code(400);
    echo json_encode(['error' => 'Cet e-mail est déjà administrateur.']);
    exit;
}

$tempPassword = bin2hex(random_bytes(6));
$stmt = db()->prepare('INSERT INTO admins (email, password_hash, role) VALUES (?, ?, "communication")');
$stmt->execute([$email, password_hash($tempPassword, PASSWORD_DEFAULT)]);

echo json_encode([
    'ok' => true,
    'id' => db()->lastInsertId(),
    'temp_password' => $tempPassword,
    'notice' => "Communiquez ce mot de passe temporaire à $email — il pourra le changer plus tard.",
]);
