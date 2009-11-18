<?php

require_once 'model.inc.php';
require_once 'arena.inc.php';
require_once 'reservation.inc.php';
require_once 'achat.inc.php';

class Match extends Model {
    public $description;

    public $arena;
	
    public $date;
	
    public $prix;
	
    public static function get($id) {
	return parent::get(__CLASS__, $id);
    }
	
    public static function filter($where) {
		return parent::filter(__CLASS__, $where);
    }

  
    public function getArena() {
        return Arena::get($this->arena);
    }

    public static function find_all() {
	return self::filter('');
    }

   public function freePlaces() {
	$reservation = count(Reservation::filter_by_match($this->id)); 
   	$achat = count(Achat::filter_by_match($this->id)); 
        $arena = $this->getArena(); 
	return ($arena->largeur* $arena->profondeur) - $reservation - $achat;
   }
}

?>
