<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_owner_json();
csrf_check();

$data = json_input();
$email = trim((string)($data['email'] ?? ''));
$title = trim((string)($data['title'] ?? ''));
if ($title === '') {
    $title = 'Communication';
} elseif (mb_strlen($title) > 100) {
    $title = mb_substr($title, 0, 100);
}

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

// Pas de mot de passe généré : le compte reste en attente tant que la personne ne s'est
// pas connectée une première fois avec cet e-mail pour choisir elle-même son mot de passe.
// Rôle "communication" par défaut (droits limités) — modifiable ensuite via api/admins-update.php.
$stmt = db()->prepare('INSERT INTO admins (email, password_hash, role, title) VALUES (?, NULL, "communication", ?)');
$stmt->execute([$email, $title]);

echo json_encode([
    'ok' => true,
    'id' => db()->lastInsertId(),
    'notice' => "Compte créé. Indiquez à $email d'aller sur la page de connexion avec cette adresse : il/elle pourra choisir son mot de passe à sa première connexion.",
]);
