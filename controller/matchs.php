<?php 
require_once '../model/match.inc.php';

function generate_vars($section, &$vars) {
    $vars['matches'] = Match::find_all();
}

?>
