<?php 

require_once '../model/arena.inc.php';


function generate_vars($section, &$vars) {
    if (!$vars['is_logged'] || !$vars['is_admin']) { 
        return; 
    } 
    
    //echo '--------<br>';
    //foreach ($_POST as $x => $y) {
    //    echo $x . ' -> ' . $y . '<br>';
    // }
    //echo '-------<br>';
    
    
    $arenas = Arena::find_all();
    $vars['arenas'] = $arenas; 

    if (isset($_POST['nom0'])) {
        for ($i = 0; $i < count($arenas); $i++) {
            $arena = $arenas[$i];

            if (isset($_POST['delete' . $i])) {
                $arena->delete();
                continue;
            }

            if ($arena->nom != $_POST['nom' . $i] || 
                $arena->sieges != $_POST['sieges' . $i]) 
            {
                $arena->nom = $_POST['nom' . $i];
                $arena->sieges = $_POST['sieges' . $i];
                $arena->save();
            }
        }
    }


    if (!empty($_POST['nom-nouveau']) && !empty($_POST['sieges-nouveau'])) {
        $arena = new Arena();
        $arena->nom = $_POST['nom-nouveau'];
        $arena->sieges = $_POST['sieges-nouveau'];
        $arena->save();
    }

    $arenas = Arena::find_all();
    $vars['arenas'] = $arenas; 
}

?>
