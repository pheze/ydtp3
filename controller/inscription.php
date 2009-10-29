<?php 
require_once '../model/utilisateur.inc.php';

function generate_vars($section, &$vars) {
    $vars['page_type'] = 'validation';
    $vars['contains_errors'] = false;

    if (empty($_POST)) {
        $vars['page_type'] = "normal";
        return;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $courriel = $_POST['courriel'];
    $jour = $_POST['jour'];
    $mois = $_POST['mois'];
    $annee = $_POST['annee'];
    $theme = $_POST['theme'];
    $sexe = isset($_POST['sexe']) ? $_POST['sexe'] : '';
    $theme = isset($_POST['theme']) ? $_POST['theme'] : 'Standard';
    $accepte = isset($_POST['accepte']) ? $_POST['accepte'] : 'off';

    $vars['errors'] = Array();
   
    if (!preg_match("/^[a-zA-Z]{3,16}$/", $username)) {
        $errors['utilisateur'] = "Le nom d'utilisateur doit contenir entre 3 et 16 caractères";
    }

    if (!preg_match("/^[a-zA-Z0123456789]{5,15}$/", $password)) {
        $errors['password'] = "Le mot de passe doit contenir minimalement 5 caractères ainsi que les symboles a-z A-Z et 0123456789";
    }

    if (!preg_match("/^[A-Za-z]{3,20}$/", $prenom)) {
        $errors['prenom'] = "Le prénom doit contenir entre 3 et 20 caractères ainsi que les symboles a-z et A-Z";
    }
    
    if (!preg_match("/^[A-Za-z]{3,20}$/", $nom)) {
        $errors['nom'] = "Le nom doit contenir entre 3 et 20 caractères ainsi que les symboles a-z et A-Z";
    }

    if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $courriel)) {
        $errors['courriel'] = "Le courriel doit être de la forme: abc@domaine.com"; 
    }

    if (!preg_match("/^\d{1,2}$/", $jour)) {
        $errors['jour'] = "Le jour dans la date de naissance possède une valeur invalide.";
    } 

    // todo : not that much necessary thought because it is a listbox with a normal default value
    // however, I guess it's possible to manually post the form without this field.

//    if (!preg_match('', $mois)) {
//        $errors['mois'] = "Le mois dans la date de naissance possède une valeur invalide.";
//    } 

//    if (!preg_match("/^\d{1,2}$/", $annee)) { value="0"
//        $errors['annee'] = "L'année dans la date de naissance possède une valeur invalide.";
//    } 

    if (!preg_match("/^[mf]$/", $sexe)) {
        $errors['sexe'] = "Le sexe est invalide.";
    }

    if (!preg_match("/^(Standard|Dark)$/", $theme)) {
        $errors['theme'] = "Le theme est invalide.";
    }

    if (!preg_match("/^[mf]$/", $sexe)) {
        $errors['sexe'] = "Le sexe est invalide.";
    }

    if (!preg_match("/^on$/", $accepte)) {
        $errors['accepte'] = "La licence n'a pas été acceptée.";
    }

    $utilisateurs = Utilisateur::filter_by_username($username);
    if (!empty($utilisateurs)) {
        $errors['utilisateur'] = 'Cet utilisateur existe déjà.';
    }


    if (!empty($errors)) {
        $vars['contains_errors'] = true;
        $vars['errors'] = $errors;
        return;
    }

    $user = new Utilisateur();
    $user->role = 1;
    $user->utilisateur = $username;
    $user->motdepasse = $password;
    $user->prenom = $prenom; 
    $user->nom = $nom;
	$user->courriel = $courriel;
    $user->jour = $jour;
	$user->mois = $mois;
	$user->annee = $annee;
    $user->sexe = ($sexe == 'f' ? 2 : 1);
    $user->theme = $theme;
    $user->save();
 
    $_SESSION['userid'] = $user->id;
    $vars['userid'] = $user->id;
    $vars['is_logged'] = true;
}

?>
