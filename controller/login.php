<?php 

require_once '../model/utilisateur.inc.php';
require_once '../lib/util.php';

function check_login($username, $password) {
    $membres = Utilisateur::filter_by_username($username);

    if (empty($membres) || $membres[0]->motdepasse != $password) {
        return -1;
    } else {
        return $membres[0]->id;
    }

}

function generate_vars($section, &$vars) {
    $vars['is_logged'] = false;

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return;
    }    

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        return;
    }


    // echo "username: " . $username . '<br>'; 
    // echo "password: " . $password . '<br>';

    $id = check_login($username, $password);
    
    if ($id == -1) {
        return;
    }

    $_SESSION['userid'] = $id;
    $vars['userid'] = $id; 
    $vars['is_logged'] = true;
    $vars['is_admin'] = is_admin();    
    
    echo is_admin();

}

?>
