<?php

/**
 * Implementation of an INPUT TEXT field
 */
require_once __DIR__ . '/../Field.php';

class Field_Select extends Field {

    /**
     * The name of the table where to take the info from
     * @var type 
     */
    protected $_otherTableName = null;

    /**
     * The name of the field in the table where to take the info from
     * @var type 
     */
    protected $_otherTableFieldName = null;

    /**
     * The name of the field in the table where to take the info from
     * @var type 
     */
    protected $_otherTablePkFieldName = 'id';

    /**
     * Option to configure static values instead of from other table
     * @var type 
     */
    protected $_staticValues = array();

    /**
     * Add the empty option to the selectbox
     * @var type 
     */
    protected $_addEmptyOption = true;

    /**
     * Option to configure static values instead of from other table
     * @param array $staticValues - example array('1' => 'foo', '2' => 'bar', '3' => 'baz')
     */
    public function setStaticValues(array $staticValues) {
        $this->_staticValues = $staticValues;
    }

    /**
     * Custom constructor with some additional fields
     * @param type $name
     * @param type $dbName
     * @param type $width
     * @param type $otherTableName
     * @param type $otherTableFieldName
     * @param type $otherTablePkFieldName
     */
    public function __construct($name, $dbName, $width, $otherTableName, $otherTableFieldName, $otherTablePkFieldName = 'id') {

        // set params for the other table
        $this->setOtherTableName($otherTableName);
        $this->setOtherTableFieldName($otherTableFieldName);
        $this->setOtherTablePkFieldName($otherTablePkFieldName);

        parent::__construct($name, $dbName, $width);
    }

    /**
     * Get the textual value from the other table
     * @return string
     */
    protected function getValueFromOtherTable() {

        if (!empty($this->_staticValues)) {
            // read the values from the static values list
            foreach ($this->_staticValues as $idx => $val) {
                if ($idx == $this->getValue()) {
                    return $val;
                }
            }
        } else {

            $db = Database::getInstance();
            $stmt = $db->prepare('
                select `' . $this->getOtherTableFieldName() . '` 
                    from `' . $this->getOtherTableName() . '` 
                        where `' . $this->getOtherTablePkFieldName() . '` = :' . $this->getOtherTablePkFieldName());
            $stmt->bindValue(':' . $this->getOtherTablePkFieldName(), $this->getValue());
            $stmt->execute();

            $res = $stmt->fetch();
            if ($res) {
                return $res[$this->getOtherTableFieldName()];
            }
        }

        return '';
    }

    /**
     * Get the textual values from the other table
     * @return string
     */
    protected function getValuesFromOtherTable() {

        $allRows = array();

        if (!empty($this->_staticValues)) {

            foreach ($this->_staticValues as $idx => $val) {
                $allRows[] = array(
                    'id' => $idx,
                    $this->getOtherTableFieldName() => $val
                );
            }
        } else {

            $db = Database::getInstance();
            $stmt = $db->prepare('
                select `' . $this->getOtherTablePkFieldName() . '`, `' . $this->getOtherTableFieldName() . '` 
                    from `' . $this->getOtherTableName() . '` 
                        order by `' . $this->getOtherTableFieldName() . '` asc');
            $stmt->execute();

            $allRows = $stmt->fetchAll();
        }

        return $allRows;
    }

    /**
     * Get the html of the field - like the regular box, 
     * but shows the field value from other table
     * @return type
     */
    public function getHtml() {

        $fieldHtml = htmlentities($this->getValueFromOtherTable(), ENT_QUOTES, 'utf-8');
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    public function getEditHtml() {

        $allRows = $this->getValuesFromOtherTable();
        $fieldHtml = '<select name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" />';

        if ($this->_addEmptyOption) {
            $fieldHtml.= '<option value=""></option>';
        }
        if ($allRows) {
            foreach ($allRows as $row) {
                $fieldHtml.= '<option value="' . $row[$this->getOtherTablePkFieldName()] . '" ' .
                        ($row[$this->getOtherTablePkFieldName()] == $this->getValue() ? 'selected' : '') .
                        '>' . htmlentities($row[$this->getOtherTableFieldName()], ENT_QUOTES, 'utf-8') . '</option>';
            }
        }
        $fieldHtml.= '</select>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     */
    public function getNewHtml() {

        $allRows = $this->getValuesFromOtherTable();
        $fieldHtml = '<select name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" />';

        if ($this->_addEmptyOption) {
            $fieldHtml.= '<option value=""></option>';
        }
        
        if ($allRows) {
            foreach ($allRows as $row) {
                $fieldHtml.= '<option value="' . $row[$this->getOtherTablePkFieldName()] . '">' .
                        htmlentities($row[$this->getOtherTableFieldName()], ENT_QUOTES, 'utf-8') .
                        '</option>';
            }
        }
        $fieldHtml.= '</select>';
        return $fieldHtml;
    }

}