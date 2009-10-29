<?php

require_once 'model.inc.php';
require_once 'match.inc.php';

class Reservation extends Model {
    public $utilisateur;

	public $match_id;
	
	public $qte;
	
	public $expiration;

    public static function get($id) {
		return parent::get(__CLASS__, $id);
	}
	
	public static function filter($where) {
		return parent::filter(__CLASS__, $where);
    }
    
    public function get_match() {
        return Match::get($this->match_id);
    }

	public static function filter_by_user($id) {
		return self::filter('utilisateur = ' . $id);
    }

    public static function find_all() {
        return self::filter('');
    }
}

?>
