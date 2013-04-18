<?php

/**
 * Generic field base class
 */
// include the base class
require_once dirname(__FILE__) . '/../HTMLElement.php';

class Field extends HTMLElement {

    /**
     * The name of the column
     * @var string
     */
    protected $_name;

    /**
     * the name of the field in the database
     * @var String
     */
    protected $_dbName;

    /**
     * the width of the field column in the table
     * @var number
     */
    protected $_width = null;

    /**
     * the height of the field (for textarea and wysiwyg)
     * 200 is the default value (in pixels)
     * @var number
     */
    protected $_height = 200;

    /**
     * the type of the field (text / password / etc)
     * @var string
     */
    protected $_type;

    /**
     * the value of the field - as it comes from the database
     * @var mixed
     */
    protected $_value;

    /**
     * the whole record value(s)
     * @var array | mixed
     */
    protected $_row;

    /**
     * Field that does not appear in the edit/add mode
     * @var bool 
     */
    protected $_readOnly = false;

    /**
     * Field that appears only in edit/add mode
     * @var bool 
     */
    protected $_editOnly = false;

    /**
     * Define the default value of the field on edit/add
     * @var mixed 
     */
    protected $_defaultValue = null;

    /**
     * Define other fields that should be modified when saving/adding a record
     * @var type 
     */
    protected $_otherFields = array();

    /**
     * Add another field that should be modified when saving/adding a record
     * 
     * !important! - when using the function, pay attension not to put the "other field"
     * in the table after this field, but BEFORE!
     * 
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

    public function getHtml() {

        $fieldHtml = htmlentities($this->getValue(), ENT_QUOTES, 'utf-8');
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     * @return string the output
     */
    protected function getEditHtml() {
        $fieldHtml = '<input type="text" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                'value="' . htmlentities($this->getValue(), ENT_QUOTES, 'utf-8') . '" ' .
                '/>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     * @return string the field edit mode
     */
    protected function getNewHtml() {
        $fieldHtml = '<input type="text" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                'value="" placeholder="' . $this->getName() . '..." ' .
                '/>';
        return $fieldHtml;
    }

    /**
     * The simplest implementation for getting the value from the post
     * @return text (`mixed` in other fields)
     */
    protected function getValueFromPost() {

        $req = Request::getInstance();

        // get the raw value from the post
        $rawValue = $req->post($this->getDbName());

        // in the simplest way, this is the new value of the field
        return $rawValue;
    }

    /**
     * Override the default __call function
     * @param type $funcName
     * @param type $args
     * @return mixed
     */
    public function __call($funcName, $args) {

        if ($funcName == 'getValueFromPost' && !is_null($this->_defaultValue)) {
            return $this->_defaultValue;
        }

        // prevent returning the "edit" html if it's a readonly or has default value
        if ($funcName == 'getEditHtml' && (!is_null($this->_defaultValue) || $this->_readOnly)) {
            return $this->getHtml();
        }

        // prevent returning the "new" html if it's a readonly or has default value
        if ($funcName == 'getNewHtml' && (!is_null($this->_defaultValue) || $this->_readOnly)) {
            return '';
        }

        // call the required function
        return parent::__call($funcName, $args);
    }

}
