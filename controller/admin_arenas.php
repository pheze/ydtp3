<?php 

require_once '../model/arena.inc.php';


function generate_vars($section, &$vars) {
    if (!$vars['is_logged'] || !$vars['is_admin']) { 
        return; 
    } 
    
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
                $arena->largeur != $_POST['largeur' . $i] || 
		$arena->profondeur != $_POST['profondeur' . $i]) 
            {
                $arena->nom = $_POST['nom' . $i];
                $arena->largeur = $_POST['largeur' . $i];
                $arena->profondeur = $_POST['profondeur' . $i];
                $arena->save();
            }
        }
    }


    if (!empty($_POST['nom-nouveau']) && !empty($_POST['largeur-nouveau']) && !empty($_POST['profondeur-nouveau'])) {
        $arena = new Arena();
        $arena->nom = $_POST['nom-nouveau'];
        $arena->largeur = $_POST['largeur-nouveau'];
        $arena->profondeur = $_POST['profondeur-nouveau'];
        $arena->save();
    }

    $arenas = Arena::find_all();
    $vars['arenas'] = $arenas; 
}

?>
