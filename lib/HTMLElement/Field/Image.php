<?php

/**
 * Implementation of an INPUT File (image) field
 */
require_once __DIR__ . '/../Field.php';

class Field_Image extends Field_File {

    /**
     * The default preview image width
     * @var type 
     */
    protected $_previewWidth = 120;

    /**
     * Get the HTML of the field
     * @return string
     */
    public function getHtml() {
        $req = Request::getInstance();
        $value = $this->getValue();
        $value = '/' . trim($value, '/');

        $fieldHtml = '<a href="' . $req->getRelativePath() . $value . '" target="_blank"><img src="' . $req->getRelativePath() . $value . '" width="' . $this->getPreviewWidth() . '" /></a>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     * This time it's with the image preview
     * @return string
     */
    public function getEditHtml() {

        $req = Request::getInstance();
        $value = $this->getValue();
        $value = '/' . trim($value, '/');

        $fieldHtml = '<img src="' . $req->getRelativePath() . $value . '" width="' . $this->getPreviewWidth() . '" /><br/><input type="file" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                '/>';
        return $fieldHtml;
    }

}