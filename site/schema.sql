-- Schéma de la base de données du site Robo'Lyon.
-- À importer une seule fois via phpMyAdmin (ou `mysql < schema.sql`) sur la base créée chez votre hébergeur.

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  -- NULL tant que la personne invitée n'a pas encore choisi son mot de passe (voir login.php).
  password_hash VARCHAR(255) NULL,
  role ENUM('owner','communication') NOT NULL DEFAULT 'communication',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS login_attempts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL,
  attempted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (email, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS content_blocks (
  block_key VARCHAR(190) PRIMARY KEY,
  value MEDIUMTEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS media (
  slot_key VARCHAR(190) PRIMARY KEY,
  kind ENUM('image','video','embed','document','model') NOT NULL DEFAULT 'image',
  path VARCHAR(255) NULL,
  embed_url VARCHAR(500) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(190) NOT NULL,
  price VARCHAR(50) NOT NULL,
  image_path VARCHAR(255) NULL,
  external_url VARCHAR(500) NULL,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mentors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(190) NOT NULL,
  role VARCHAR(190) NOT NULL,
  photo_path VARCHAR(255) NULL,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  subscribed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS sponsors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(190) NOT NULL,
  logo_path VARCHAR(255) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS actus (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_label VARCHAR(190) NOT NULL,
  title VARCHAR(255) NOT NULL,
  image_path VARCHAR(255) NULL,
  published_at DATE NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS teams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  program ENUM('FRC','FTC') NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  name VARCHAR(190) NOT NULL,
  status_label VARCHAR(190) NOT NULL DEFAULT 'Active',
  description TEXT,
  description_en TEXT NULL,
  photo_path VARCHAR(255) NULL,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS team_members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT NOT NULL,
  name VARCHAR(190) NOT NULL,
  role VARCHAR(190) NOT NULL,
  photo_path VARCHAR(255) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(190) NOT NULL,
  email VARCHAR(190) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ===== Données de départ =====

INSERT INTO teams (program, slug, name, status_label, description, photo_path, sort_order) VALUES
('FRC', 'frc-5553', 'Équipe 5553', 'En pause cette saison', 'Chaque saison, l''équipe 5553 conçoit, fabrique et pilote deux robots rigoureusement identiques pour affronter d''autres équipes du monde entier — avec plusieurs qualifications au championnat mondial FIRST®. Cette année, nous mettons la FRC en pause pour concentrer nos ressources sur le développement de nos équipes FTC, qui passent de 3 à 4 équipes. Un retour de la FRC est prévu dès que l''encadrement le permettra.', 'assets/img/robots/tenor2024-300x225.png', 0),
('FTC', '23147', 'Équipe 23147', 'Active', 'Notre équipe FTC historique, engagée dans les compétitions régionales FIRST® Tech Challenge.', NULL, 1),
('FTC', '26762', 'Équipe 26762', 'Active', 'Une de nos équipes FTC, portée par des élèves du lycée Notre Dame de Bellegarde.', NULL, 2),
('FTC', '26796', 'Équipe 26796', 'Active', 'Une équipe complémentaire, pour permettre à davantage d''élèves de découvrir la robotique de compétition.', NULL, 3),
('FTC', 'nouvelle-equipe', 'Nouvelle équipe FTC', 'Lancement 2026', 'Notre 4ème équipe FTC, lancée cette année — nom et numéro d''équipe à préciser dès l''inscription officielle.', NULL, 4);

INSERT INTO team_members (team_id, name, role, sort_order)
SELECT id, 'À compléter', role, ord FROM teams
JOIN (
  SELECT 1 AS ord, 'Capitaine d''équipe' AS role
  UNION SELECT 2, 'Responsable mécanique'
  UNION SELECT 3, 'Responsable électronique'
  UNION SELECT 4, 'Responsable programmation'
  UNION SELECT 5, 'Mentor référent'
) roles ON 1=1
WHERE teams.slug = 'frc-5553';

INSERT INTO team_members (team_id, name, role, sort_order)
SELECT id, 'À compléter', role, ord FROM teams
JOIN (
  SELECT 1 AS ord, 'Capitaine' AS role
  UNION SELECT 2, 'Mécanique'
  UNION SELECT 3, 'Programmation'
  UNION SELECT 4, 'Communication'
) roles ON 1=1
WHERE teams.slug IN ('23147', '26762', '26796', 'nouvelle-equipe');

INSERT INTO mentors (name, role, sort_order) VALUES
('À compléter', 'Mentor technique', 1),
('À compléter', 'Mentor communication', 2),
('À compléter', 'Mentor référent association', 3);

INSERT INTO sponsors (name, logo_path, sort_order) VALUES
('SDRA Lyon', 'sponsors/01-SDRA.png', 1),
('FIRST France', 'sponsors/02-FIRST-FRANCE.png', 2),
('Lycée Notre Dame de Bellegarde', 'sponsors/03-NDB.png', 3),
('Groupe Noël', 'sponsors/04-GROUPE-NOEL.png', 4),
('Groupe BBL', 'sponsors/05-BBL.png', 5),
('Immobilière de Bellegarde', 'sponsors/07-immobiliere-de-Bellegarde.png', 6),
('EkoAlu', 'sponsors/08-EKOALU.png', 7),
('Lions Club Val de Saône', 'sponsors/09-LIONS-CLUB.png', 8),
('Crédit Mutuel', 'sponsors/19-credit-Mutuel.png', 9),
('HAAS', 'sponsors/20-HAAS.png', 10),
('Rotary Lyon', 'sponsors/21-Rotary-Lyon.png', 11),
('Mme Cadeau', 'sponsors/22-Mme-Cadeau.png', 12),
('eLCIA', 'sponsors/23-eLCIA.png', 13),
('VAHLE', 'sponsors/23-VAHLE.png', 14),
('Région Auvergne-Rhône-Alpes', 'sponsors/27-Region-AURA.png', 15),
('BIX', 'sponsors/28-BIX.png', 16),
('CIC', 'sponsors/29-CIC.png', 17),
('L''Épi Fleuri', 'sponsors/30-Epi-Fleuri.png', 18),
('Main Tendue Pérou', 'sponsors/31-Main-Tendue-Perou.png', 19),
('Terre Citoyenne Solidaire', 'sponsors/32-Terre-citoyenne-solidaire.png', 20),
('Clasy', 'sponsors/clasy.png', 21),
('iDO', 'sponsors/iDO_Logo_Colored.svg', 22),
('Kardol', 'sponsors/Kardol.png', 23),
('ADDE', 'sponsors/Logo-ADDE.png', 24),
('Leobotics', 'sponsors/leobotics.png', 25),
('MAHP', 'sponsors/logo-MAHP.png', 26),
('SERFIM', 'sponsors/logo-SERFIM.png', 27),
('Riberry Conseil', 'sponsors/RiberryConseil.png', 28),
('RS France', 'sponsors/rs_france_logo.jpeg', 29);
