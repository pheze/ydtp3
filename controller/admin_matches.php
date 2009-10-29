<?php 

require_once '../model/arena.inc.php';
require_once '../model/match.inc.php';


function generate_vars($section, &$vars) {
    if (!$vars['is_logged'] || !$vars['is_admin']) { 
        return; 
    } 

    $matches = Match::find_all();
    $vars['matches'] = $matches;
    $vars['arenas'] = Arena::filter('');
    
    if (isset($_POST['description0'])) {
        for ($i = 0; $i < count($matches); $i++) {
            $match = $matches[$i];


            if (isset($_POST['delete' . $i])) {
                $match->delete();
                continue;
            }


            if ($match->description != $_POST['description' . $i] || 
                $match->date != $_POST['date' . $i] ||  
                $match->arena != $_POST['arena' . $i] ||  
                $match->prix != $_POST['prix' . $i])
            {
                $match->description = $_POST['description' . $i];
                $match->date = $_POST['date' . $i];
                $match->arena = $_POST['arena' . $i];
                $match->prix = $_POST['prix' . $i];
                $match->save();
            }
        }
    }


    if (!empty($_POST['description-nouveau']) && 
        !empty($_POST['date-nouveau']) &&
        !empty($_POST['arena-nouveau']) &&
        !empty($_POST['prix-nouveau']))

    { 
        $match = new Match();
        $match->description = $_POST['description-nouveau'];
        $match->date = $_POST['date-nouveau'];
        $match->arena = $_POST['arena-nouveau'];
        $match->prix = $_POST['prix-nouveau'];

        $arena = Arena::get($match->arena);
        $match->places = $arena->sieges;

        $match->save();

    }

    $matches = Match::find_all();
    $vars['matches'] = $matches; 
}

?>
