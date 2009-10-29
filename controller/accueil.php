<?php 

function generate_vars($section, &$vars) {
    if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = 0;
    } else {
        $_SESSION['count']++;
    }

    $vars['count'] = $_SESSION['count'];
}

?>
