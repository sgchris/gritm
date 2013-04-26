<?php

/**
 * Implementation of an INPUT TEXT field
 */
class Field_Date extends Field {

    /**
     * Date format to display in the table
     * @var string
     */
    protected $_dateFormat = 'd M Y <\\i>H:i</\\i>';

    /**
     * Get the `view` mode for the field
     * @return string
     */
    public function getHtml() {
        if (false !== ($timeStamp = strtotime($this->getValue()))) {
            $fieldHtml = date($this->_dateFormat, $timeStamp);
        } else {
            $fieldHtml = '<i class="small muted">(wrong date format)</i>';
        }
        
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    protected function getEditHtml() {
        $fieldHtml = '<input type="date" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                'value="' . htmlentities($this->getValue(), ENT_QUOTES, 'utf-8') . '" ' .
                '/>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     */
    protected function getNewHtml() {
        $fieldHtml = '<input type="date" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                'value="" placeholder="' . $this->getName() . '..." ' .
                '/>';
        return $fieldHtml;
    }

}