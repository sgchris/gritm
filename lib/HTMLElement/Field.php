<?php

/**
 * Generic field base class
 */
// include the base class
require_once dirname(__FILE__) . '/../HTMLElement.php';

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
     * the value of the field - as it comes from the database
     */
    protected $_value;

    /**
     * the whole record value(s)
     */
    protected $_row;

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

    /**
     * Assign a value to the field
     * @param type $value
     * @param type $row
     * @return object $this
     */
    public function setValue($value, $row = null) {
        $this->_value = $value;
        $this->_row = $row;

        return $this;
    }

}
