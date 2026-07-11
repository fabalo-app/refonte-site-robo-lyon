<?php
require_once __DIR__ . '/../db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

function current_admin(): ?array {
    if (empty($_SESSION['admin_id'])) return null;
    static $admin = null;
    if ($admin === null) {
        $stmt = db()->prepare('SELECT id, email, role FROM admins WHERE id = ?');
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch() ?: false;
    }
    return $admin ?: null;
}

function is_logged_in(): bool {
    return current_admin() !== null;
}

function is_owner(): bool {
    $a = current_admin();
    return $a !== null && $a['role'] === 'owner';
}

/** Mode édition actif = connecté ET a choisi "aperçu mode admin" pour cette session. */
function is_edit_mode(): bool {
    return is_logged_in() && !empty($_SESSION['edit_mode']);
}

function require_login(): array {
    $a = current_admin();
    if (!$a) {
        header('Location: login.php');
        exit;
    }
    return $a;
}

function require_owner(): array {
    $a = require_login();
    if ($a['role'] !== 'owner') {
        http_response_code(403);
        echo "Accès réservé au propriétaire du site.";
        exit;
    }
    return $a;
}

/** À appeler en tête des endpoints /api qui modifient du contenu. */
function require_login_json(): array {
    $a = current_admin();
    if (!$a) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Non connecté.']);
        exit;
    }
    return $a;
}

function require_owner_json(): array {
    $a = require_login_json();
    if ($a['role'] !== 'owner') {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Réservé au propriétaire.']);
        exit;
    }
    return $a;
}
