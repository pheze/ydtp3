<?php

require_once 'model.inc.php';
require_once 'match.inc.php';

class Reservation extends Model {
    public $utilisateur;

	public $id_match;
	
	public $expiration;

	public $rangee;
	
	public $siege;

    public static function get($id) {
		return parent::get(__CLASS__, $id);
	}
	
	public static function filter($where) {
		return parent::filter(__CLASS__, $where);
    }
    
    public function get_match() {
        return Match::get($this->id_match);
    }

    public static function filter_by_user($id) {
		return self::filter('utilisateur = ' . $id);
    }

    public static function filter_by_match($id_match) {
        return self::filter('id_match = ' . $id_match);
    }

    public static function filter_by_match_rangee_siege($id_match, $rangee, $siege) {
		return self::filter('id_match = ' . $id_match . ' and rangee = ' . $rangee . ' and siege = ' . $siege);
    }

    public static function find_all() {
        return self::filter('');
    }
}

?>
