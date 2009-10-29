<?php 

require_once '../model/match.inc.php';

function generate_vars($section, &$vars) {

    if (!isset($_GET['id'])) {
        return;
    }

    $vars['match'] = Match::get($_GET['id']);
}

?>
