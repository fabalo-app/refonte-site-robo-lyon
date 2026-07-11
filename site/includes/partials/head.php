<?php
/** Attend $pageTitle défini avant l'inclusion. */
?>
<!DOCTYPE html>
<html lang="<?= h(current_lang()) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($pageTitle ?? SITE_NAME) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<script type="module" src="https://unpkg.com/@google/model-viewer@3.5.0/dist/model-viewer.min.js"></script>
</head>
<body<?= is_edit_mode() ? ' class="rl-edit-mode"' : '' ?>>
