<?php
/**
 * Generic field base class
 */

// include the base class
require_once dirname(__FILE__).'/../HTMLElement.php';

class Field extends HTMLElement {

	/**
	 * The name of the column
	 */
	private $_name;

	/**
	 * the name of the field in the database
	 */
	private $_dbName;

	/**
	 * the type of the field (text / password / etc)
	 */
	private $_type;

	/**
	 * Get the HTML of the field
	 */
	public function getHtml() {
		
	}

}
