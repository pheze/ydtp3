<?php

require_once 'model.inc.php';

// Run unit tests for the Model class.	
function test_load() {
	class TestLoad extends Model {
		public $foo;
					
		public static function load($attr) {
			return parent::load(__CLASS__, $attr);
		}
	}
	
	$attr = array("foo" => "barbara");
	
	$obj = TestLoad::load($attr);
	
	assert($obj->foo == "barbara");
}

class Arena extends Model {
	public $sieges;
	
	public static function get($attr) {
		return parent::get(__CLASS__, $attr);
	}
	
	public static function filter($attr) {
		return parent::filter(__CLASS__, $attr);
	}
}

function test_get() {			
	$obj = Arena::get(1);
			
	assert($obj->sieges == 85);
}

function test_filter() {			
	$arr = Arena::filter("");
		
	assert(count($arr) != 0);
}

function test_save_delete() {			
	$obj = new Arena();
	
	$obj->sieges = 5;
	
	$old_count = count(Arena::filter(""));
	
	$obj->save();
	
	assert(isset($obj->id));
	
	$obj->sieges = 7;
	
	$obj->save();
	
	$obj->delete();
	
	assert($old_count == count(Arena::filter("")));
}
	
test_load();

test_get();

test_filter();

test_save_delete();
?>