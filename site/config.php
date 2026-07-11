<?php
// Renseignez ici les identifiants MySQL fournis par votre hébergeur (OVH, o2switch...).
// Sur o2switch/OVH mutualisé, DB_HOST vaut souvent "localhost", et le nom de base / utilisateur
// vous sont donnés dans votre panneau d'administration d'hébergement.
define('DB_HOST', getenv('ROBOLYON_DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('ROBOLYON_DB_PORT') ?: '3306');
define('DB_NAME', getenv('ROBOLYON_DB_NAME') ?: 'robolyon');
define('DB_USER', getenv('ROBOLYON_DB_USER') ?: 'root');
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
