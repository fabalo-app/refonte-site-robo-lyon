<?php
// Identifiants MySQL de production (hébergement InfinityFree).
// Les valeurs après "?:" sont utilisées telles quelles en production. En local, définir les
// variables d'environnement ROBOLYON_DB_* (voir README) prend le pas dessus pour pointer vers
// une base de test sans toucher à ce fichier.
define('DB_HOST', getenv('ROBOLYON_DB_HOST') ?: 'sql206.infinityfree.com');
define('DB_PORT', getenv('ROBOLYON_DB_PORT') ?: '3306');
define('DB_NAME', getenv('ROBOLYON_DB_NAME') ?: 'if0_42397806_robolyon');
define('DB_USER', getenv('ROBOLYON_DB_USER') ?: 'if0_42397806');
// À REMPLIR UNIQUEMENT sur le serveur, directement depuis le File Manager InfinityFree — ne
// jamais coller ce mot de passe ici en local ni le partager dans une conversation.
define('DB_PASS', getenv('ROBOLYON_DB_PASS') ?: '');

define('SITE_NAME', "Robo'Lyon");

// Dossier où sont stockés les fichiers envoyés par les administrateurs (photos, logos, vidéos).
define('UPLOADS_DIR', __DIR__ . '/uploads');
define('UPLOADS_URL', 'uploads');

define('MAX_UPLOAD_BYTES', 15 * 1024 * 1024);

// Les modèles 3D (.glb/.gltf) peuvent être plus volumineux que les photos/vidéos courantes.
// Vérifiez aussi upload_max_filesize / post_max_size dans le php.ini de l'hébergeur si les
// envois échouent pour des fichiers proches de cette limite.
define('MAX_MODEL_UPLOAD_BYTES', 60 * 1024 * 1024);
