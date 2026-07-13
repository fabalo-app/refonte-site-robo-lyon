<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_owner_json();
csrf_check();

$data = json_input();
$id = (int)($data['id'] ?? 0);
$title = trim((string)($data['title'] ?? ''));
$role = (string)($data['role'] ?? '');

if (!in_array($role, ['owner', 'communication'], true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Rôle invalide.']);
    exit;
}
if ($title === '') {
    http_response_code(400);
    echo json_encode(['error' => "L'étiquette ne peut pas être vide."]);
    exit;
}
if (mb_strlen($title) > 100) {
    $title = mb_substr($title, 0, 100);
}

$stmt = db()->prepare('SELECT role FROM admins WHERE id = ?');
$stmt->execute([$id]);
$current = $stmt->fetch();
if (!$current) {
    http_response_code(404);
    echo json_encode(['error' => 'Administrateur introuvable.']);
    exit;
}

// Empêche de retirer les droits du dernier propriétaire restant : le site doit toujours
// garder au moins un compte capable de gérer les autres administrateurs.
if ($current['role'] === 'owner' && $role !== 'owner') {
    $countStmt = db()->prepare("SELECT COUNT(*) c FROM admins WHERE role = 'owner' AND id != ?");
    $countStmt->execute([$id]);
    $otherOwners = (int) $countStmt->fetch()['c'];
    if ($otherOwners === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Impossible : il doit toujours rester au moins un propriétaire.']);
        exit;
    }
}

$stmt = db()->prepare('UPDATE admins SET title = ?, role = ? WHERE id = ?');
$stmt->execute([$title, $role, $id]);

echo json_encode(['ok' => true]);
