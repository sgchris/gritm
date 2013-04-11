<?php

/**
 * Description of a file
 * 
 * @since Mar 19, 2013
 * @author Gregoryc
 */
require_once __DIR__ . '/../Button.php';

class Button_Delete extends Button {

    /**
     * avoid from including the JS several times
     * @var bool 
     */
    protected static $_javascriptIncluded = null;
    
    /**
     * The table this button is in
     * @var type 
     */
    protected $_table = null;

    /**
     * 
     * @return string
     */
    public function getHtml() {
        return '<a class="btn" button-operation="delete" table-db-name="' . (is_null($this->getTable()) ? '' : $this->getTable()->getDbName()) . '">' .
                '<i class="icon-remove"></i> Delete' .
                '</a>';
    }

    /**
     * Get the javascript that operates the button
     */
    public function getJavascript() {
        
        if (self::$_javascriptIncluded) {
            return '';
        }
        
        $_tableName = is_null($this->getTable()) ? '' : $this->getTable()->getDbName();
        
        // let the application include the 
        self::$_javascriptIncluded = true;
        return '
                [].forEach.call(document.querySelectorAll("a.btn[button-operation=\'delete\']"), function(elem) {
                    elem.onclick = function() {
                        // get the selected row
                        var selectedRow = document.querySelector("table[table-db-name=\''.$_tableName.'\'] tr.selected");
                        var selectedRowPkValue = selectedRow ? selectedRow.getAttribute("row-pk") : null;
                        Gritm.popup.showDeleteRecord(elem.getAttribute("table-db-name"), selectedRowPkValue);
                    };
                });
            ';
    }

}