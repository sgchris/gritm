<?php

/**
 * Description of a file
 * 
 * @since Mar 19, 2013
 * @author Gregoryc
 */

class Button_Add extends Button {

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
        return '<a class="btn" button-operation="add" table-db-name="' . (is_null($this->getTable()) ? '' : $this->getTable()->getDbName()) . '">' .
                '<i class="icon-asterisk"></i> Add' .
                '</a>';
    }

    /**
     * Get the javascript that operates the button
     */
    public function getJavascript() {
        
        if (self::$_javascriptIncluded) {
            return '';
        }
        
        // let the application include the 
        self::$_javascriptIncluded = true;
        
        return '
                [].forEach.call(document.querySelectorAll("a.btn[button-operation=\'add\']"), function(elem) {
                    elem.onclick = function() {
                        Gritm.popup.showAddNewRecord(elem.getAttribute("table-db-name"));
                    };
                });
            ';
    }

}