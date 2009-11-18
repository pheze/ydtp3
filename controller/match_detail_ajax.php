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


if (!isset($_GET['i']) || !isset($_GET['j']) || !isset($_GET['id']) || !isset($_GET['userid'])) {
 echo 'err';
 return;
} 

$i = $_GET['i'];
$j = $_GET['j'];
$id = $_GET['id'];
$userid = $_GET['userid'];

echo get_siege_info($userid, $id, $i, $j);
?>

