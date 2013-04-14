<?php

/**
 * Implementation of an INPUT TEXT field
 */

class Field_Text extends Field {

    public function getHtml() {

        $fieldHtml = htmlentities($this->getValue(), ENT_QUOTES, 'utf-8');
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    public function getEditHtml() {
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
     */
    public function getNewHtml() {
        $fieldHtml = '<input type="text" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                'value="" placeholder="' . $this->getName() . '..." ' .
                '/>';
        return $fieldHtml;
    }

}