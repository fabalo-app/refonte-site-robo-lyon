<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$name = trim((string)($_POST['name'] ?? ''));
$role = trim((string)($_POST['role'] ?? ''));
if ($name === '' || $role === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Nom et rôle requis.']);
    exit;
}

$photoPath = null;
if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    try {
        $photoPath = store_upload($_FILES['photo'], 'mentors', IMAGE_MIMES);
    } catch (RuntimeException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

$maxOrder = (int) db()->query('SELECT COALESCE(MAX(sort_order),0) m FROM mentors')->fetch()['m'];
$stmt = db()->prepare('INSERT INTO mentors (name, role, photo_path, sort_order) VALUES (?, ?, ?, ?)');
$stmt->execute([$name, $role, $photoPath, $maxOrder + 1]);

echo json_encode(['ok' => true, 'id' => db()->lastInsertId()]);
