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
	protected $_name;

	/**
	 * the name of the field in the database
	 */
	protected $_dbName;

	/**
	 * the width of the field column in the table
	 */
	protected $_width = null;

	/**
	 * the type of the field (text / password / etc)
	 */
	protected $_type;
    
    /**
     * Default constructor for a field
     * 
     * @param type $name
     * @param type $dbName
     * @param type $width
     */
    public function __construct($name, $dbName, $width = null) {
        $this->setName($name);
        $this->setDbName($dbName);
        $this->setWidth($width);
    }

}
