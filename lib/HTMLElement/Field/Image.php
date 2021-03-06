<?php

// include the `WideImage` object
require_once THIRD_PATRY_DIR . '/WideImage/lib/WideImage.php';

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
     * The default preview image width
     * @var type 
     */
    protected $defaultPreviewWidth = 120;

    /**
     * The default preview image width
     * @var type 
     */
    protected $_previewWidth = null;

    /**
     * The default preview image height
     * @var type 
     */
    protected $_previewHeight = null;

    /**
     * Resize the uploaded image
     * @param type $x
     * @param type $y
     * @return $this
     */
    public function resize($x, $y, $originalImageFieldName = null) {
        $this->_resize = array($x, $y, 'originalImageFieldName' => $originalImageFieldName);
        return $this;
    }

    /**
     * Get the HTML of the field
     * @return string
     */
    public function getHtml() {
        $req = Request::getInstance();
        
        // read the value of the field (the image)
        $value = $this->getValue();
        if (empty($value)) {
            return '<span class="small muted">(empty)</span>';
        }
        
        $value = '/' . trim($value, '/');

        $style = '';
        if ( $this->getPreviewHeight() || $this->getPreviewWidth()) {
            if ($this->getPreviewWidth()) {
                $style.= 'width:' . $this->getPreviewWidth() . 'px;';
            }
            
            if ($this->getPreviewHeight()) {
                $style.= 'height:' . $this->getPreviewHeight() . 'px;';
            }
        } else {
            $style.= ' width:' . $this->defaultPreviewWidth . 'px;';
        }

        $fieldHtml = '<a href="' . $req->getRelativePath() . $value . '" target="_blank">' .
                '<img src="' . $req->getRelativePath() . $value . '" style="'.$style.'" />' .
                '</a>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     * This time it's with the image preview
     * @return string
     */
    protected function getEditHtml() {

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

    /**
     * Upload the file and return the relative path to it
     * add "other field" for original image
     * @return string
     */
    public function getValueFromPost() {
        $returnValue = $this->getValue();

        try {
            // check if any file uploaded
            $req = Request::getInstance();
            if ($req->validFilesUploaded()) {

                // check if particularly this file uploaded
                $file = WideImage::loadFromUpload($this->getDbName());

                // prepare the destination directory
                if (is_null($this->_uploadDir)) {
                    throw new Exception('Destination folder is not set for field ' . $this->getDbName());
                }
                $uploadDir = ROOT_DIR . $this->_uploadDir;
                @mkdir($uploadDir, 0777, true);

                // get the new file name
                $uploadedFileInfo = $req->file($this->getDbName());
                $ext = pathinfo($uploadedFileInfo['name'], PATHINFO_EXTENSION);
                $newFileName = $this->getPreserveOriginalFileName() ? $uploadedFileInfo['name'] : uniqid() . '.' . $ext;

                // store the file
                $file->saveToFile($uploadDir . '/' . $newFileName);

                // prepare the return value
                $uploadedFilePath = $this->_uploadDir . '/' . $newFileName;

                // check if the original file has to be kept
                if (!empty($this->_resize)) {
                    $resizeX = $this->_resize[0];
                    $resizeY = $this->_resize[1];

                    // define the original file as "other" field
                    if (!is_null($this->_resize['originalImageFieldName'])) {
                        $this->addOtherField($this->_resize['originalImageFieldName'], $uploadedFilePath);
                    }

                    // set the relative path for the resized image - the one that will be returned
                    $uploadedFilePath = $uploadedFilePath . '_R' . $resizeX . 'X' . $resizeY . '.' . $ext;

                    // set the upload directory for the resized image
                    $uploadedFileDir = $uploadDir . '/' . $newFileName . '_R' . $resizeX . 'X' . $resizeY . '.' . $ext;

                    // resize and save the file
                    $file->resize($resizeX, $resizeY)->saveToFile($uploadedFileDir);
                }

                $returnValue = $uploadedFilePath;
            }
        } catch (Exception $e) {
            fputs(STDERR, $e->getMessage());
        }

        // return the previous value
        return $returnValue;
    }

}