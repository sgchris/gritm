<?php

/**
 * Implementation of an INPUT TEXT field
 */
require_once __DIR__ . '/../Field.php';

class Field_File extends Field {

    /**
     * Tell the uploader to change / do not change the name of the file
     * @var type 
     */
    protected $_preserveOriginalFileName = true;

    /**
     * Define the destination directory
     * @var type 
     */
    protected $_uploadDir = null;

    /**
     * Define the destination directory
     * @example "/gallery/10", "/uploaded_files", "homepage_files"
     * @param type $uploadDir
     */
    public function setUploadDir($uploadDir) {

        // remove the leading and trailing slashes
        $uploadDir = trim($uploadDir, '/');
        $uploadDir = trim($uploadDir, '\\');

        $this->_uploadDir = '/' . $uploadDir;
        return $this;
    }

    /**
     * Get the HTML of the field
     * @return string
     */
    public function getHtml() {
        $req = Request::getInstance();
        $value = $this->getValue();
        $value = '/'.trim($value, '/');
        $fieldHtml = '<a href="' . $req->getRelativePath() . $value . '" target="_blank">' . htmlentities($this->getValue(), ENT_QUOTES, 'utf-8') . '</a>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `edit` mode
     * @return string
     */
    public function getEditHtml() {
        $fieldHtml = '<input type="file" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                '/>';
        return $fieldHtml;
    }

    /**
     * Get the html of the field when in `new` mode
     * @return string
     */
    public function getNewHtml() {
        $fieldHtml = '<input type="file" ' .
                'name="' . $this->getDbName() . '" ' .
                'field-db-name="' . $this->getDbName() . '" ' .
                'style="width:' . $this->getWidth() . 'px;" ' .
                '/>';
        return $fieldHtml;
    }

    /**
     * Upload the file and return the relative path to it
     * @return string
     */
    public function getValueFromPost() {
        $returnValue = $this->getValue();

        try {
            // check if any file uploaded
            $req = Request::getInstance();
            if ($req->validFilesUploaded()) {

                // check if particularly this file uploaded
                $file = $req->file($this->getDbName());
                if ($file && $file['error'] == 0) {
                    
                    // create the destination directory
                    $uploadDir = defined('ROOT_DIR') ? ROOT_DIR : (defined('GRITM_DIR') ? realpath(GRITM_DIR . '/..') : null);
                    if (is_null($uploadDir) || is_null($this->_uploadDir)) {
                        throw new Exception('Destination folder is not set for field '.$this->getDbName());
                    } else {
                        $uploadDir.= $this->_uploadDir;
                        @mkdir($uploadDir . '/', 0777, true);
                    }

                    // check the file and move the uploaded file
                    if (is_uploaded_file($file['tmp_name'])) {
                        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $newFileName = $this->getPreserveOriginalFileName() ? $file['name'] : uniqid() . '.' . $ext;

                        if (move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $newFileName)) {
                            $returnValue = $this->_uploadDir . '/' . $newFileName;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            fputs(STDERR, $e->getMessage());
        }

        // return the previous value
        return $returnValue;
    }

}