<?php
/**
 * Dictionnaire des textes fixes de l'interface (menus, boutons, titres génériques, labels).
 * Le contenu éditorial (mission, bios, descriptions...) passe par edit_text()/text_i18n()
 * dans helpers.php, qui gèrent leur propre variante anglaise stockée en base.
 */
$GLOBALS['RL_I18N'] = [
    'fr' => [
        'nav.accueil' => 'Accueil',
        'nav.association' => "L'association",
        'nav.histoire' => 'Notre histoire',
        'nav.mentors' => 'Nos mentors',
        'nav.activites' => 'Activités',
        'nav.valeurs' => 'Valeurs',
        'nav.missions' => 'Missions',
        'nav.equipes' => 'Nos équipes',
        'nav.ftc_all' => 'FTC — Toutes les équipes',
        'nav.actus' => 'Actus',
        'nav.sponsors' => 'Sponsors',
        'nav.boutique' => 'Boutique',
        'nav.contact' => 'Contact',
        'nav.espace_admin' => 'Espace admin',
        'nav.connexion_admin' => 'Se connecter',
        'nav.menu' => 'Ouvrir le menu',

        'footer.navigation' => 'Navigation',
        'footer.contact' => 'Contact',
        'footer.follow' => 'Suivez-nous',
        'footer.newsletter' => 'Newsletter',
        'footer.newsletter_desc' => "Recevez les grandes actualités de l'association par e-mail (compétitions, portes ouvertes...).",
        'footer.newsletter_button' => "S'inscrire",
        'footer.newsletter_ok' => 'Merci, vous êtes inscrit·e !',
        'footer.rights' => 'Tous droits réservés.',

        'common.add' => 'Ajouter',
        'common.cancel' => 'Annuler',
        'common.save' => 'Enregistrer',
        'common.send' => 'Envoyer',
        'common.edit' => 'Modifier',
        'common.delete' => 'Supprimer',
        'common.back_to_teams' => '‹ Nos équipes',
        'common.back_to_ftc' => '‹ Équipes FTC',
        'common.order' => 'Commander',
        'common.contact_to_order' => 'Nous contacter pour commander',
        'common.loading' => 'Chargement du modèle 3D…',

        'page.contact.title' => 'Contact',
        'page.contact.name' => 'Nom',
        'page.contact.email' => 'E-mail',
        'page.contact.subject' => 'Sujet',
        'page.contact.message' => 'Message',
        'page.contact.send' => 'Envoyer le message',
        'page.contact.coords' => 'Nos coordonnées',
        'page.contact.address' => 'Adresse',
        'page.contact.access' => 'Accès',
        'page.contact.sent_title' => 'Message envoyé, merci !',
        'page.contact.sent_desc' => 'Nous vous répondrons dès que possible.',

        'page.equipes.title' => 'Nos équipes',
        'page.sponsors.title' => 'Nos sponsors',
        'page.actus.title' => 'Actualités & affiches',
        'page.actus.empty_title' => 'Aucune actualité publiée pour le moment',
        'page.actus.empty_desc' => "L'équipe communication met régulièrement à jour cette page. En attendant, suivez-nous sur les réseaux sociaux pour ne rien manquer de la saison.",
        'page.association.title' => "L'association",
        'page.boutique.title' => 'Boutique',
        'page.boutique.empty_title' => 'Boutique bientôt disponible',
        'page.boutique.empty_desc' => "Nous préparons notre boutique en ligne (goodies, vêtements aux couleurs de l'équipe...). Revenez bientôt !",

        'robot.title' => 'Le robot, saison par saison',
        'robot.weight' => 'Poids',
        'robot.code' => 'Voir le code',
        'robot.model' => 'Voir le modèle 3D',
        'robot.add_model' => 'Ajouter un modèle 3D interactif',
        'robot.replace_model' => 'Remplacer le modèle 3D',
        'robot.palmares' => 'Palmarès',
        'robot.team' => "L'équipe",
        'robot.add_member' => '+ Ajouter un membre',

        'lang.fr' => 'FR',
        'lang.en' => 'EN',

        'robot.section' => 'Le robot',
        'assoc.since' => 'Depuis 2014',
        'page.soutenir.title' => 'Nous soutenir',
        'page.contact.error' => 'Merci de renseigner votre nom, un e-mail valide et un message.',
        'team.active_one' => 'équipe active',
        'team.active_many' => 'équipes actives',
        'team.noun_one' => 'équipe',
        'team.noun_many' => 'équipes',
        'admin.mode_active' => 'Mode admin actif — double-cliquez un texte, une image ou une vidéo pour la modifier.',
        'admin.logged_as' => 'Connecté en tant que',
        'admin.enable_edit' => "Activer le mode édition",
        'admin.disable_edit' => 'Repasser en vue publique',
        'common.modified' => 'Modifié ✓',

        'assoc.activites_subtitle' => "La robotique de compétition, c'est bien plus que construire un robot.",
        'assoc.valeurs_intro' => 'Nous partageons la philosophie du <em>Cooperative Professionalism®</em> de FIRST®, fondée sur le principe de Dr. Woodie Flowers : « Quand des professionnels appliquent leurs connaissances avec courtoisie, et que chacun agit avec intégrité et sensibilité, tout le monde y gagne et la société en profite. »',
        'sponsors.dossier_label' => 'Télécharger le dossier de sponsoring',
        'document.soon' => 'Dossier à venir.',
        'document.replace' => '📎 Remplacer le PDF',
        'document.upload' => '📎 Envoyer le PDF',
        'media.team_photo' => "Photo de l'équipe",
        'media.map' => 'Carte à venir',
        'media.hero_action' => "Glissez une photo ou vidéo d'action ici",
        'media.photo_placeholder' => 'Photo',
        'frc.team_subtitle' => 'Rôles et responsables actuels.',
        'actus.poster_soon' => 'Affiche à venir',
        'soutenir.jump_don' => 'Faire un don',
        'soutenir.jump_mentor' => 'Devenir mentor',
        'soutenir.jump_sponsor' => 'Devenir sponsor',

        'title.home' => "Robo'Lyon — La robotique de compétition à Lyon",
        'title.association' => "L'association — Robo'Lyon",
        'title.equipes' => 'Nos équipes — Robo\'Lyon',
        'title.actus' => "Actualités — Robo'Lyon",
        'title.sponsors' => "Sponsors — Robo'Lyon",
        'title.contact' => "Contact — Robo'Lyon",
        'title.soutenir' => "Nous soutenir — Robo'Lyon",
        'title.team_not_found' => "Équipe introuvable — Robo'Lyon",
        'error.team_not_found' => 'Équipe introuvable',
        'common.fr_fallback_tooltip' => 'Version anglaise à venir — affichage en français',
    ],
    'en' => [
        'nav.accueil' => 'Home',
        'nav.association' => 'About us',
        'nav.histoire' => 'Our story',
        'nav.mentors' => 'Our mentors',
        'nav.activites' => 'Activities',
        'nav.valeurs' => 'Values',
        'nav.missions' => 'Missions',
        'nav.equipes' => 'Our teams',
        'nav.ftc_all' => 'FTC — All teams',
        'nav.actus' => 'News',
        'nav.sponsors' => 'Sponsors',
        'nav.boutique' => 'Shop',
        'nav.contact' => 'Contact',
        'nav.espace_admin' => 'Admin area',
        'nav.connexion_admin' => 'Log in',
        'nav.menu' => 'Open menu',

        'footer.navigation' => 'Navigation',
        'footer.contact' => 'Contact',
        'footer.follow' => 'Follow us',
        'footer.newsletter' => 'Newsletter',
        'footer.newsletter_desc' => "Get the association's major news by e-mail (competitions, open days...).",
        'footer.newsletter_button' => 'Subscribe',
        'footer.newsletter_ok' => "Thanks, you're subscribed!",
        'footer.rights' => 'All rights reserved.',

        'common.add' => 'Add',
        'common.cancel' => 'Cancel',
        'common.save' => 'Save',
        'common.send' => 'Send',
        'common.edit' => 'Edit',
        'common.delete' => 'Delete',
        'common.back_to_teams' => '‹ Our teams',
        'common.back_to_ftc' => '‹ FTC teams',
        'common.order' => 'Order',
        'common.contact_to_order' => 'Contact us to order',
        'common.loading' => 'Loading 3D model…',

        'page.contact.title' => 'Contact',
        'page.contact.name' => 'Name',
        'page.contact.email' => 'Email',
        'page.contact.subject' => 'Subject',
        'page.contact.message' => 'Message',
        'page.contact.send' => 'Send message',
        'page.contact.coords' => 'Our details',
        'page.contact.address' => 'Address',
        'page.contact.access' => 'Getting here',
        'page.contact.sent_title' => 'Message sent, thank you!',
        'page.contact.sent_desc' => "We'll get back to you as soon as possible.",

        'page.equipes.title' => 'Our teams',
        'page.sponsors.title' => 'Our sponsors',
        'page.actus.title' => 'News & posters',
        'page.actus.empty_title' => 'No news published yet',
        'page.actus.empty_desc' => 'The communications team updates this page regularly. In the meantime, follow us on social media so you don\'t miss anything this season.',
        'page.association.title' => 'About us',
        'page.boutique.title' => 'Shop',
        'page.boutique.empty_title' => 'Shop coming soon',
        'page.boutique.empty_desc' => "We're preparing our online shop (merch, team-colored apparel...). Check back soon!",

        'robot.title' => 'The robot, season by season',
        'robot.weight' => 'Weight',
        'robot.code' => 'View the code',
        'robot.model' => 'View 3D model',
        'robot.add_model' => 'Add an interactive 3D model',
        'robot.replace_model' => 'Replace 3D model',
        'robot.palmares' => 'Achievements',
        'robot.team' => 'The team',
        'robot.add_member' => '+ Add a member',

        'lang.fr' => 'FR',
        'lang.en' => 'EN',

        'robot.section' => 'The robot',
        'assoc.since' => 'Since 2014',
        'page.soutenir.title' => 'Support us',
        'page.contact.error' => 'Please fill in your name, a valid e-mail address and a message.',
        'team.active_one' => 'active team',
        'team.active_many' => 'active teams',
        'team.noun_one' => 'team',
        'team.noun_many' => 'teams',
        'admin.mode_active' => 'Admin mode active — double-click any text, image or video to edit it.',
        'admin.logged_as' => 'Logged in as',
        'admin.enable_edit' => 'Turn on edit mode',
        'admin.disable_edit' => 'Back to public view',
        'common.modified' => 'Saved ✓',

        'assoc.activites_subtitle' => 'Competitive robotics is about much more than just building a robot.',
        'assoc.valeurs_intro' => "We share FIRST®'s <em>Cooperative Professionalism®</em> philosophy, based on Dr. Woodie Flowers' principle: “When professionals apply their knowledge with courtesy, and everyone acts with integrity and sensitivity, everybody wins and society benefits.”",
        'sponsors.dossier_label' => 'Download the sponsorship packet',
        'document.soon' => 'Document coming soon.',
        'document.replace' => '📎 Replace the PDF',
        'document.upload' => '📎 Upload a PDF',
        'media.team_photo' => 'Team photo',
        'media.map' => 'Map coming soon',
        'media.hero_action' => 'Drop an action photo or video here',
        'media.photo_placeholder' => 'Photo',
        'frc.team_subtitle' => 'Current roles and leads.',
        'actus.poster_soon' => 'Poster coming soon',
        'soutenir.jump_don' => 'Make a donation',
        'soutenir.jump_mentor' => 'Become a mentor',
        'soutenir.jump_sponsor' => 'Become a sponsor',

        'title.home' => "Robo'Lyon — Competitive robotics in Lyon",
        'title.association' => "About us — Robo'Lyon",
        'title.equipes' => "Our teams — Robo'Lyon",
        'title.actus' => "News — Robo'Lyon",
        'title.sponsors' => "Sponsors — Robo'Lyon",
        'title.contact' => "Contact — Robo'Lyon",
        'title.soutenir' => "Support us — Robo'Lyon",
        'title.team_not_found' => "Team not found — Robo'Lyon",
        'error.team_not_found' => 'Team not found',
        'common.fr_fallback_tooltip' => 'English version coming soon — showing French',
    ],
];

/**
 * Langue courante : priorité absolue au choix explicite de l'utilisateur (cookie posé par un
 * clic sur FR/EN, voir bootstrap.php). Sans ce cookie, on propose la langue préférée du
 * navigateur (en-tête Accept-Language) — jamais mémorisé tant que l'utilisateur n'a pas
 * lui-même choisi.
 */
function current_lang(): string {
    if (isset($_COOKIE['rl_lang'])) {
        return $_COOKIE['rl_lang'] === 'en' ? 'en' : 'fr';
    }
    return detect_browser_lang();
}

/** Langue préférée du visiteur d'après l'en-tête HTTP Accept-Language ("fr-FR,fr;q=0.9,en;q=0.8" ...). */
function detect_browser_lang(): string {
    $header = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    if ($header === '') {
        return 'fr';
    }
    $best = null;
    $bestQ = -1.0;
    foreach (explode(',', $header) as $part) {
        $part = trim($part);
        if ($part === '') continue;
        $bits = explode(';', $part);
        $lang = strtolower(trim(explode('-', $bits[0])[0]));
        $q = 1.0;
        if (isset($bits[1]) && preg_match('/q=([0-9.]+)/', $bits[1], $m)) {
            $q = (float) $m[1];
        }
        if ($q > $bestQ) {
            $bestQ = $q;
            $best = $lang;
        }
    }
    return $best === 'en' ? 'en' : 'fr';
}

/** Traduit une clé de l'interface (textes fixes, non éditables depuis l'admin). */
function t(string $key, ?string $fallback = null): string {
    $lang = current_lang();
    return $GLOBALS['RL_I18N'][$lang][$key]
        ?? $GLOBALS['RL_I18N']['fr'][$key]
        ?? $fallback
        ?? $key;
}
