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
    public function getHtml($alterDateFormat = null) {
        if (is_null($alterDateFormat)) {
            $alterDateFormat = $this->_dateFormat;
        }
        
        if (false !== ($timeStamp = strtotime($this->getValue()))) {
            $fieldHtml = date($alterDateFormat, $timeStamp);
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
                'value="' . $this->getHtml('Y-m-d') . '" ' .
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