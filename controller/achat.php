<?php 

require_once '../model/achat.inc.php';

function generate_vars($section, &$vars) {
    if (!$vars['is_logged']) { return; }
    
    $vars['achats'] = Achat::filter_by_user($vars['userid']);
}

?>
