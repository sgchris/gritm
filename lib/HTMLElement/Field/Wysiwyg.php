<?php

/**
 * Implementation of an TEXTAREA field
 */
class Field_Wysiwyg extends Field {

    /**
     * the height of the div width the preview text within the table.
     * @var number
     */
    protected $_previewHeight = 150;

    /**
     * Get the html of the field, wrapped with a div with max-height value (overflow auto)
     * @return string
     */
    public function getHtml() {

        $fieldHtml = '<div style="max-height: '.$this->getPreviewHeight().'px;overflow:auto;">'.$this->getValue().'</div>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     */
    protected function getEditHtml() {
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
    protected function getNewHtml() {
        $fieldHtml = '<textarea ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'placeholder="' . $this->getName() . '..." ' .
                'style="width:' . $this->getWidth() . 'px; height: ' . $this->getHeight() . 'px">' .
                '</textarea>';
        return $fieldHtml;
    }

    /**
     * Initialize the textarea as the wysiwyg editor
     * @return type
     */
    public function getJavascript() {
        return 'if (document.querySelector("textarea[name=\'' . $this->getDbName() . '\']")) CKEDITOR.replace( "' . $this->getDbName() . '" );';
    }

}