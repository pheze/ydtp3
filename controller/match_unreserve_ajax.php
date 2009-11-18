<?php 

require_once '../model/match.inc.php';
require_once '../model/reservation.inc.php';

function generate_vars($section, &$vars) {
	$vars['success'] = false;
	
	if (!$vars['is_logged']) {
		return;
  	}

	if (!isset($_GET['id']) || !isset($_GET['i']) || !isset($_GET['j'])) {
		return;
	}    

	$idmatch = $_GET['id'];
	$i = $_GET['i'];
	$j = $_GET['j'];


	$reservations = Reservation::filter_by_match_rangee_siege($idmatch, $i, $j);
	$reservation = $reservations[0];
	$reservation->delete();


	$vars['success'] = true;
}


?>
