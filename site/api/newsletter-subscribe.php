<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
csrf_check();

$data = json_input();
$email = trim((string)($data['email'] ?? ''));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Adresse e-mail invalide.']);
    exit;
}

$stmt = db()->prepare('INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)');
$stmt->execute([$email]);

echo json_encode(['ok' => true]);
