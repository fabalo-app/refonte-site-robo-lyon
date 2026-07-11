<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();

$title = trim((string)($_POST['title'] ?? ''));
$dateLabel = trim((string)($_POST['date_label'] ?? ''));
$publishedAt = trim((string)($_POST['published_at'] ?? ''));

if ($title === '' || $dateLabel === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Titre et date requis.']);
    exit;
}
if ($publishedAt === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $publishedAt)) {
    $publishedAt = date('Y-m-d');
}

$imagePath = null;
if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    try {
        $imagePath = store_upload($_FILES['image'], 'actus', IMAGE_MIMES);
    } catch (RuntimeException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

$maxOrder = (int) db()->query('SELECT COALESCE(MAX(sort_order),0) m FROM actus')->fetch()['m'];
$stmt = db()->prepare('INSERT INTO actus (date_label, title, image_path, published_at, sort_order) VALUES (?, ?, ?, ?, ?)');
$stmt->execute([$dateLabel, $title, $imagePath, $publishedAt, $maxOrder + 1]);

echo json_encode(['ok' => true, 'id' => db()->lastInsertId()]);
