<?php

include '../lib/util.php';
include '../lib/source/serpent.class.php';
require_once '../model/utilisateur.inc.php';


clear_deprecated_reserved_matches();


session_start();

$sections = array('accueil', 'inscription', 'login', 'matchs', 'panier', 'achat', 'match_detail', 'signout', 'reservation_billet', 'confirmation_achat_billet', 'achat_billet', 'configuration', 'admin_matches', 'admin_arenas', 'admin');

$section = get($_GET, 'section', 'accueil');
if ($section == 'accueil') {
    $section = get($_POST, 'section', 'accueil');
}

if (!in_array($section, $sections)) {
    $section = 'unknown';
}

$vars = array();
$vars['userid'] = get_auth();
$vars['is_admin'] = is_admin();
$vars['is_logged'] = ($vars['userid'] >= 0);
$vars['theme'] = 'standard.css';


include($section . '.php');
generate_vars($section, $vars); 
$vars['section_name'] = ucfirst(str_replace('_', ' ', $section));

if ($vars['is_logged']) {
    $user = Utilisateur::get($vars['userid']);
    if ($user->theme == 'Dark') {
        $vars['theme'] = 'dark.css';
    }
}


$serpent = new serpent();
$serpent->compile_dir = '../view/templates_compiled';
$serpent->addPluginConfig('resource', 'file', array(
    'template_dir' => '../view/templates/')
);

$serpent->pass($vars);

echo $serpent->render($section);
?>
