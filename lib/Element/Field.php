<?php
/**
 * Generic field base class
 */

// include the base class
require_once dirname(__FILE__).'/../Element.php';

class Field extends Element {

	/**
	 * the name of the field in the database
	 */
	private $field_database_name;

	/**
	 * set the name of the field in the database
	 */
	private function setDatabaseName($field_database_name) {
		$this->field_database_name = $field_database_name;
	}

	/**
	 * get the name of the field in the database
	 */
	private function getDatabaseName() {
		return $this->field_database_name;
	}

	/**
	 * the type of the field (text / password / etc)
	 */
	private $type;

	/**
	 * set the type of the field
	 */
	private function setType($type) {
		$this->type = $type;
	}

	/**
	 * get the type of the field
	 */
	private function getType() {
		return $this->type;
	}

}
