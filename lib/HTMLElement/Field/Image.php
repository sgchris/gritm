<?php

/**
 * Implementation of an INPUT File (image) field
 */

class Field_Image extends Field_File {

    /**
     * Resize the image to dimensions array([0] => xxx, [1] => yyy)
     * @var type 
     */
    protected $_resize = array();
    
    /**
     * Resize the uploaded image
     * @param type $x
     * @param type $y
     * @return $this
     */
    public function resize($x, $y) {
        $this->_resize = array($x, $y);
        return $this;
    }
    
    /**
     *
     * @var type 
     */
    protected $_keepOriginalImage = false;
    
    /**
     * The name of the field that will hold the original image name
     * @var type 
     */
    protected $_keepOriginalImageFieldName = null;
    
    /**
     * 
     * @param type $_keepOriginalImage
     * @param type $_keepOriginalImageFieldName
     */
    public function setKeepOriginalImage($originalImageFieldName) {
        $this->_keepOriginalImage = true;
        $this->_keepOriginalImageFieldName = $originalImageFieldName;
    }
    
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