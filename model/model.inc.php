<?php

require_once 'db.inc.php';

abstract class Model {
	public $id;
	

	private static function get_table_name($class) {
		return 'tp3_' . strtolower($class) . 's';
	}

	// Construct a model object from an array of attributes.
	protected static function load($class, $attr) {
		$obj = new $class();


		// Use reflection to dynamically iterate through each field in the model.
        //foreach ($attr as $x => $y) {
        //    echo $x . '->' . $y . '<br>';
        // }

		foreach (get_object_vars($obj) as $field => $value) {
			if (array_key_exists($field, $attr)) {
				$obj->$field = $attr[$field];
			}
		}
		
		return $obj;
	}
	
	// Return a model object matching the database row with the given id.
    public static function get($class, $id) {
		$query = "SELECT * FROM " . Model::get_table_name($class) . " WHERE id = $id;";
        $result = mysql_query($query);
		if (!$result) {
			return $result;
        }

		$attr = mysql_fetch_assoc($result);
	    return self::load($class, $attr);
    }

	// Return an array of model objects matching the given condition.
	protected static function filter($class, $where) {
		$query = "SELECT * FROM " . Model::get_table_name($class) . ($where == "" ? "":" WHERE $where");
		$result = mysql_query($query);
		if (!$result) {
			return $result;
		}
		$out = array();		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$out[] = self::load($class, $row);
		}		
		mysql_free_result($result);
		return $out;
	}
	
	// Save the model object to the associated database row.
	public function save() {
		if (isset($this->id)) {
			$query = "UPDATE " . Model::get_table_name(get_class($this)) . " SET ";

			foreach(get_object_vars($this) as $key => $val) {
				if ($key == "id") {
					continue;
				}					
				elseif (strtolower($val) == 'null') {
					$query.= "`$key` = NULL, ";
				}
				elseif (strtolower($val) == 'now()') {
					$query.= "`$key` = NOW(), ";
				}
				else {
					$query.= "`$key`='".$val."', ";
				}
			}
			
			$query = rtrim($query, ', ') . "WHERE id = $this->id";
			
			mysql_query($query);
		}
		else {
			$query = "INSERT INTO " . Model::get_table_name(get_class($this)) . " ";
			$v = '';
			$n = '';
			foreach(get_object_vars($this) as $key=>$val) {
				if ($key == "id") {
					continue;
				}
				
				$n .= "`$key`, ";
				if (strtolower($val) == 'null') {
					$v .= "NULL, ";
				}
				elseif (strtolower($val) == 'now()') {
					$v.="NOW(), ";
				}
				else {
					$v.= "'" . $val . "', ";
				}
			}
			$query .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";
			
			mysql_query($query);
			
			$this->id = mysql_insert_id();
		}
	}

	// Delete the database row associated to this model object.
	public function delete() {
		if (!isset($this->id)) {
			return;
		}
		$query = "DELETE FROM " . Model::get_table_name(get_class($this)) . " WHERE id = $this->id;";
	    $result = mysql_query($query);
	}
	
	// Return a string representing this model object.
	public function __tostring() {
		return "&lt;model table=" . Model::get_table_name(get_class($this)) . " id=$this->id /&gt;";
	}
}

?>
