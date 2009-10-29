<?php

require_once 'model.inc.php';

class Arena extends Model  {
    public $nom;

	public $sieges;

    public static function get($id) {
		return parent::get(__CLASS__, $id);
	}
	
	public static function filter($where) {
		return parent::filter(__CLASS__, $where);
	}
	
	public static function find_all() {
		return self::filter('');
	}
}

?>
