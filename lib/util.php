<?php

require_once '../model/utilisateur.inc.php';
require_once '../model/reservation.inc.php';
require_once '../model/match.inc.php';


function get($array, $key, $default) {
    if (isset($array[$key])) { 
        return $array[$key];
    } else { 
        return $default;
    }
}

function get_auth() {
    if (!isset($_SESSION['userid'])) {
        return -1;
    }

    return $_SESSION['userid'];
}

function is_admin() {
    if (!isset($_SESSION['userid'])) {
        return false;
    }
    
    $user = Utilisateur::get($_SESSION['userid']);
    if ($user == null || $user->role != 2) { 
        return false; 
    }
        
    return true;
}

function ajust_ticket_and_delete($reservation) {
    $match = Match::get($reservation->match_id);
    $new_places = $match->places + $reservation->qte;
    $match->places = $new_places;
    $match->save();
    $reservation->delete();
}


function clear_deprecated_reserved_matches() {
    $MAX_TIME = 60 * 1; // 1 minute TODO TOCHANGE

    foreach (Reservation::find_all() as $reservation) {
        $diff = time() - strtotime($reservation->expiration);

        if ($diff > $MAX_TIME) {
            ajust_ticket_and_delete($reservation);
        }

    }   
}


?>
