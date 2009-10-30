<?php 

require_once '../model/match.inc.php';
require_once '../model/reservation.inc.php';
require_once '../model/achat.inc.php';

function generate_vars($section, &$vars) {
    $vars['ok'] = false;

    if (!$vars['is_logged']) {
        return;
    }

    $reservations = Reservation::filter_by_user($vars['userid']);
    foreach ($reservations as $reservation) {
        $achat = new Achat(); 
        $achat->utilisateur = $reservation->utilisateur;
        $achat->id_match = $reservation->id_match;
        $achat->siege = $reservation->siege;
        $achat->rangee = $reservation->rangee;
        $achat->date = 'now()';
        $achat->save();

        $reservation->delete();
    }
        
    $vars['ok'] = true;

}

?>
