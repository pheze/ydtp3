<?php 

function generate_vars($section, &$vars) {
    session_destroy();
    $_SESSION = array();
    $vars['userid'] = -1;
    $vars['is_logged'] = false;
    $vars['is_admin'] = false;
}

?>
