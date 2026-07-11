<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$name = trim((string)($_POST['name'] ?? ''));
if ($name === '' || mb_strlen($name) > 190) {
    http_response_code(400);
    echo json_encode(['error' => 'Nom du sponsor requis.']);
    exit;
}
if (empty($_FILES['logo'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Logo requis.']);
    exit;
}

try {
    $path = store_upload($_FILES['logo'], 'sponsors', IMAGE_MIMES);
} catch (RuntimeException $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$maxOrder = (int) db()->query('SELECT COALESCE(MAX(sort_order),0) m FROM sponsors')->fetch()['m'];
$stmt = db()->prepare('INSERT INTO sponsors (name, logo_path, sort_order) VALUES (?, ?, ?)');
$stmt->execute([$name, $path, $maxOrder + 1]);

echo json_encode(['ok' => true, 'id' => db()->lastInsertId()]);
