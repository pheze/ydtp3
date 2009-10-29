<?php 

require_once '../model/utilisateur.inc.php';

function updateIfNecessary(&$user, $what, $field) {
    if (isset($_POST[$what]) && !empty($_POST[$what]) && $_POST[$what] != $user->$field) {
        $user->$field = $_POST[$what];
        return 1;
    }

    return 0;
}

function generate_vars($section, &$vars) {
    if (!$vars['is_logged']) { return; } 

        $counter = 0;

        $user = Utilisateur::get($vars['userid']); 

        $counter += updateIfNecessary($user, 'password', 'motdepasse');
        $counter += updateIfNecessary($user, 'prenom', 'prenom');
        $counter += updateIfNecessary($user, 'nom', 'nom');
        $counter += updateIfNecessary($user, 'jour', 'jour');
        $counter += updateIfNecessary($user, 'mois', 'mois');
        $counter += updateIfNecessary($user, 'annee', 'annee');
        $counter += updateIfNecessary($user, 'courriel', 'courriel');
        $counter += updateIfNecessary($user, 'sexe', 'sexe');
        $counter += updateIfNecessary($user, 'theme', 'theme');

        if ($counter > 0) { 
            $user->save();
        }
    
    $vars['user'] = Utilisateur::get($vars['userid']);
}

?>
