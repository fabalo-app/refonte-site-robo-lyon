<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$name = trim((string)($_POST['name'] ?? ''));
$status = trim((string)($_POST['status_label'] ?? 'Active'));
$description = trim((string)($_POST['description'] ?? ''));

if ($name === '' || mb_strlen($name) > 190) {
    http_response_code(400);
    echo json_encode(['error' => "Nom de l'équipe requis."]);
    exit;
}

$slug = slugify($name);
$base = $slug;
$i = 2;
$exists = db()->prepare('SELECT COUNT(*) c FROM teams WHERE slug = ?');
do {
    $exists->execute([$slug]);
    if ((int)$exists->fetch()['c'] === 0) break;
    $slug = $base . '-' . $i++;
} while (true);

$maxOrder = (int) db()->query("SELECT COALESCE(MAX(sort_order),0) m FROM teams WHERE program='FTC'")->fetch()['m'];
$stmt = db()->prepare('INSERT INTO teams (program, slug, name, status_label, description, sort_order) VALUES ("FTC", ?, ?, ?, ?, ?)');
$stmt->execute([$slug, $name, $status, $description, $maxOrder + 1]);
$teamId = db()->lastInsertId();

foreach (['Capitaine', 'Mécanique', 'Programmation', 'Communication'] as $i2 => $role) {
    db()->prepare('INSERT INTO team_members (team_id, name, role, sort_order) VALUES (?, "À compléter", ?, ?)')
        ->execute([$teamId, $role, $i2 + 1]);
}

echo json_encode(['ok' => true, 'slug' => $slug]);
