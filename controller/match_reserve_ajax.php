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



	$id_match = $_GET['id'];
	$rangee = $_GET['i'];
	$siege = $_GET['j'];
	$userid = $vars['userid'];

	$reservation = new Reservation();
	$reservation->utilisateur = $userid;
	$reservation->id_match = $id_match;
	$reservation->expiration = 'now()';
	$reservation->rangee = $rangee;
	$reservation->siege = $siege;
	$reservation->save();


	$vars['success'] = true;
}


?>
