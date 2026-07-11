<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');
require_login_json();
csrf_check();
$_SESSION['edit_mode'] = empty($_SESSION['edit_mode']);
echo json_encode(['edit_mode' => $_SESSION['edit_mode']]);
