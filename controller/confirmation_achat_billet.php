<?php 

require_once '../model/match.inc.php';

function generate_vars($section, &$vars) {
    if (!isset($_GET['match_id']) || !isset($_GET['nombre_billet'])) {
        $vars['ok'] = false;
        return;
    }  
    
    $vars['ok'] = true;
    $vars['ok_place'] = false;

    if (Match::get($_GET['match_id'])->places < $_GET['nombre_billet']) {
        return;
    }


    $vars['match_id'] = $_GET['match_id'];
    $vars['nombre_billet'] = $_GET['nombre_billet'];
    $vars['ok_place'] = true;
}

?>
