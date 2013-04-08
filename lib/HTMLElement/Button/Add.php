<?php

/**
 * Description of a file
 * 
 * @since Mar 19, 2013
 * @author Gregoryc
 */
require_once __DIR__ . '/../Button.php';

class Button_Add extends Button {

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
        return '
            console.log(typeof(__BUTTON_ADD_JAVASCRIPT));
            if (typeof(__BUTTON_ADD_JAVASCRIPT) == "undefined") {
                console.log("inside");
                __BUTTON_ADD_JAVASCRIPT = true;
                [].forEach.call(document.querySelectorAll("a.btn[button-operation=\'add\']"), function(elem) {
                    elem.onclick = function() {
                        Gritm.popup.showAddNewRecord(elem.getAttribute("table-db-name"));
                    };
                });
            }
            ';
    }

}