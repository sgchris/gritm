<?php

/**
 * Implementation of an INPUT TEXT field
 */

class Field_Checkbox extends Field {

    public function getHtml() {

        $fieldHtml = $this->getValue() ? '<b>V</b>' : '<span style="color:#AAA">&times;</span>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    public function getEditHtml() {
        $fieldHtml = '<input type="checkbox" ' .
                'name="' . $this->getDbName() . '" ' .
                'value="1" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                ($this->getValue() ? 'checked' : '') .
                '/>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     */
    public function getNewHtml() {
        $fieldHtml = '<input type="checkbox" ' .
                'name="' . $this->getDbName() . '" ' .
                'value="1" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                '/>';
        return $fieldHtml;
    }

    public function getValueFromPost() {
        $req = Request::getInstance();

        // get the raw value from the post
        if ($req->post($this->getDbName())) {
            $rawValue = '1';
        } else {
            $rawValue = '0';
        }

        // in the simplest way, this is the new value of the field
        return $rawValue;
    }

}