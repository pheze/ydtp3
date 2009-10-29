<?php

require_once 'model.inc.php';

class Utilisateur extends Model {
    public $role;

	public $utilisateur;
	
	public $motdepasse;
	
	public $prenom;
	
	public $nom;

	public $courriel;
	
	public $jour;
	
	public $mois;
	
	public $annee;

	public $sexe;
	
	public $theme;

    public static function get($id) {
		return parent::get(__CLASS__, $id);
	}
	
	public static function filter($where) {
		return parent::filter(__CLASS__, $where);
	}
	
	public static function filter_by_username($username) {
		return self::filter('utilisateur = "' . $username . '"');
	}
}

?>
