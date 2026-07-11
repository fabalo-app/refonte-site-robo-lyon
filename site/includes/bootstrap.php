<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/i18n.php';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['fr', 'en'], true)) {
    setcookie('rl_lang', $_GET['lang'], time() + 60 * 60 * 24 * 365, '/');
    $_COOKIE['rl_lang'] = $_GET['lang'];
    $qs = $_GET;
    unset($qs['lang']);
    $redirect = strtok($_SERVER['REQUEST_URI'], '?');
    if ($qs) {
        $redirect .= '?' . http_build_query($qs);
    }
    header('Location: ' . $redirect);
    exit;
}
