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
     * the height of the field (for textarea and wysiwyg)
     * 200 is the default value (in pixels)
     */
    protected $_height = 200;

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
     * Define other fields that should be modified when saving/adding a record
     * @var type 
     */
    protected $_otherFields = array();
    
    /**
     * Add another field that should be modified when saving/adding a record
     * @param type $fieldName
     * @param type $fieldValue
     */
    protected function addOtherField($fieldName, $fieldValue) {
        $this->_otherFields[$fieldName] = $fieldValue;
        return $this;
    }
    
    /**
     * Check if there are other fields that should be taken in consideration
     * @return type
     */
    public function hasOtherFields() {
        return count($this->_otherFields) > 0;
    }
    
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
    
    /**
     * The simplest implementation for getting the value from the post
     * @return text
     */
    public function getValueFromPost() {
        $req = Request::getInstance();
        
        // get the raw value from the post
        $rawValue = $req->post($this->getDbName());
        
        // in the simplest way, this is the new value of the field
        return $rawValue;
    }

}
