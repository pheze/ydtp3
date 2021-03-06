<?php 

require_once '../model/match.inc.php';
require_once '../model/reservation.inc.php';
require_once '../model/achat.inc.php';

function get_siege_info($userid, $id_match, $i, $j) {
 $reservations = Reservation::filter_by_match_rangee_siege($id_match, $i, $j);
 if (!empty($reservations)) {
  if ($reservations[0]->utilisateur == $userid) {
   return 'siege_reserve_moi';
  } else {
   return 'siege_reserve_autre';
  }
 } 

 $achats = Achat::filter_by_match_rangee_siege($id_match, $i, $j);
 if (!empty($achats)) {
  if ($achats[0]->utilisateur == $userid) {
   return 'siege_achete_moi';
  } else {
   return 'siege_achete_autre';
  }
 } 

 return 'siege_disponible';
}

function generate_vars($section, &$vars) {

    if (!isset($_GET['id'])) {
        return;
    }

    $vars['match'] = Match::get($_GET['id']);
    $vars['arena'] = $vars['match']->getArena();
    
    $classes = array();
    for ($i = 0; $i < $vars['arena']->profondeur; $i++) {
     $classes[$i] = array();
     for ($j = 0; $j < $vars['arena']->largeur; $j++) {
      $classes[$i][$j] = get_siege_info($vars['userid'], $_GET['id'], $i, $j);
     }
    }

    $vars['classes'] = $classes;

}

?>
