# Site Robo'Lyon — guide de mise en ligne

Ce dossier contient le site complet, prêt à être déposé sur un hébergement mutualisé
(OVH, o2switch, etc.) qui fournit PHP + MySQL.

## 1. Créer la base de données

Dans votre panneau d'hébergement (espace client OVH / o2switch), créez une base MySQL.
Notez bien : le nom de la base, le nom d'utilisateur, le mot de passe, et l'adresse du
serveur (`DB_HOST`, souvent `localhost` ou une adresse du type `xxx.mysql.dbaas.ovh.net`).

Ouvrez phpMyAdmin depuis votre panneau, sélectionnez la base créée, onglet **Importer**,
et importez le fichier `schema.sql` de ce dossier. Cela crée toutes les tables et
pré-remplit le site avec le contenu actuel (équipes, sponsors...).

## 2. Envoyer les fichiers

Envoyez **tout le contenu de ce dossier** (`site/`, pas le dossier parent) à la racine de
votre hébergement web (souvent `www/` ou `public_html/`) via FTP (FileZilla, Cyberduck...).

## 3. Configurer la connexion à la base

Éditez `config.php` et remplacez les valeurs par défaut par celles de votre base :

```php
define('DB_HOST', getenv('ROBOLYON_DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('ROBOLYON_DB_NAME') ?: 'robolyon');
define('DB_USER', getenv('ROBOLYON_DB_USER') ?: 'root');
define('DB_PASS', getenv('ROBOLYON_DB_PASS') ?: '');
```

Remplacez simplement les valeurs après `?:` (entre guillemets).

## 4. Créer le premier compte administrateur

Visitez `https://votredomaine.fr/login.php`. Comme aucun administrateur n'existe encore,
le site vous proposera de créer le **compte propriétaire** (e-mail + mot de passe).
C'est ce compte qui pourra ensuite inviter d'autres personnes (équipe communication...).

## 5. Comment fonctionne l'édition du site (façon Elementor)

- En bas à droite du site, un bouton discret **« Connexion admin »** permet de se connecter.
  Les visiteurs normaux n'ont jamais besoin de se connecter.
- Une fois connecté, un bouton **« Activer le mode édition »** apparaît en bas à droite.
  Cliquez dessus pour entrer en mode édition (et repasser en vue publique à tout moment).
- En mode édition :
  - **Double-cliquez sur un texte** pour le modifier directement, puis cliquez ailleurs
    pour enregistrer (`Échap` annule la modification).
  - **Double-cliquez sur une image ou une vidéo** pour la remplacer (fichier ou lien
    YouTube/Vimeo).
  - Des boutons **« + Ajouter un sponsor »**, **« + Ajouter une équipe »**,
    **« + Ajouter un membre »**, **« + Ajouter une actualité »** apparaissent aux bons
    endroits, avec une croix rouge pour supprimer un élément existant.
- Espace admin (`admin.php`) : le compte propriétaire peut y inviter de nouveaux
  administrateurs (rôle « communication », limité à l'édition de contenu — pas de
  gestion des comptes).

## 6. Limites à connaître

- L'édition de texte est en **texte brut** (pas de gras/italique/liens dans le texte
  édité) — pour une mise en forme plus riche, il faudrait un éditeur enrichi, non inclus
  ici pour rester simple et robuste.
- Le formulaire de contact utilise la fonction `mail()` de PHP. Sur la plupart des
  hébergements mutualisés cela fonctionne directement ; si les e-mails n'arrivent pas,
  chaque message est de toute façon conservé dans la base (table `contact_messages`)
  et consultable via phpMyAdmin.
- Les mots de passe des nouveaux administrateurs sont générés automatiquement (affichés
  une seule fois à la création) — chacun peut le changer ensuite dans
  « Espace admin → Mon compte ».
