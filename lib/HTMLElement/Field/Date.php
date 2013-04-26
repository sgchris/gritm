<?php

/**
 * Implementation of an INPUT TEXT field
 */

class Field_Date extends Field {

    /**
     * set the default date type (to display)
     * @var string
     */
    protected $_dateFormat = 'd.m.Y H:i';
    
    public function getHtml() {
        
        // parse the date (as it appears on the database (`dateTime` field)
        if (false !== ($timeStamp = strtotime($this->getValue()))) {
            return date($this->_dateFormat, $timeStamp);
        } 
        
        return '';
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    protected function getEditHtml() {
//        $fieldHtml = '<input type="text" ' .
//                'name="' . $this->getDbName() . '" ' .
//                'field-db-name="' . $this->getDbName() . '" ' .
//                'style="width:' . $this->getWidth() . 'px;" ' .
//                'value="' . htmlentities($this->getValue(), ENT_QUOTES, 'utf-8') . '" ' .
//                '/>';
//        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     */
    protected function getNewHtml() {
//        $fieldHtml = '<input type="text" ' .
//                'name="' . $this->getDbName() . '" ' .
//                'field-db-name="' . $this->getDbName() . '" ' .
//                'style="width:' . $this->getWidth() . 'px;" ' .
//                'value="" placeholder="' . $this->getName() . '..." ' .
//                '/>';
//        return $fieldHtml;
    }

}