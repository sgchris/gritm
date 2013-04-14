<?php

/**
 * Implementation of an TEXTAREA field
 */

class Field_Textarea extends Field {

    public function getHtml() {

        $fieldHtml = htmlentities($this->getValue(), ENT_QUOTES, 'utf-8');
        $fieldHtml = nl2br($fieldHtml);
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    public function getEditHtml() {
        $fieldHtml = '<textarea ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px; height: ' . $this->getHeight() . 'px">' .
                htmlentities($this->getValue(), ENT_QUOTES, 'utf-8') .
                '</textarea>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     */
    public function getNewHtml() {
        $fieldHtml = '<textarea ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'placeholder="' . $this->getName() . '..." ' .
                'style="width:' . $this->getWidth() . 'px; height: ' . $this->getHeight() . 'px">' .
                '</textarea>';
        return $fieldHtml;
    }

}