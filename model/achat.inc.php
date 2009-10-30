<?php

require_once 'model.inc.php';
require_once 'match.inc.php';

class Achat extends Model {
    public $utilisateur;

	public $id_match;
	
	public $date;

	public $siege;

	public $rangee;

    public function get_match() {
        return Match::get($this->id_match);
    }

    public static function get($id) {
		return parent::get(__CLASS__, $id);
	}
	
	public static function filter($where) {
		return parent::filter(__CLASS__, $where);
	}
	
	public static function filter_by_user($id) {
		return self::filter('utilisateur = ' . $id);
    }

}

?>
