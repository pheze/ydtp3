<?php

require_once 'model.inc.php';
require_once 'arena.inc.php';

class Match extends Model {
    public $description;

	public $arena;
	
	public $date;
	
	public $prix;
	
	public $places;

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
}

?>
