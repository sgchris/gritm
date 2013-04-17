<?php

/**
 * Implementation of an INPUT FILE field
 */
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
        $value = '/' . trim($value, '/');
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
     * Upload a file from the $_FILES array
     * @param type $file - item from the $_FILES array
     * @return string - the new relative path of the file
     * @throws Exception
     */
    protected function _uploadFile($file) {
        if ($file && $file['error'] == 0) {

            // create the destination directory
            $uploadDir = defined('ROOT_DIR') ? ROOT_DIR : (defined('GRITM_DIR') ? realpath(GRITM_DIR . '/..') : null);
            if (is_null($uploadDir) || is_null($this->_uploadDir)) {
                throw new Exception('Destination folder is not set for field ' . $this->getDbName());
            } else {
                $uploadDir.= $this->_uploadDir;
                @mkdir($uploadDir, 0777, true);
            }

            // check the file and move the uploaded file
            if (is_uploaded_file($file['tmp_name'])) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newFileName = $this->getPreserveOriginalFileName() ? $file['name'] : uniqid() . '.' . $ext;

                if (move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $newFileName)) {
                    return $this->_uploadDir . '/' . $newFileName;
                } else {
                    throw new Exception('Error moving the file to its final destination (`move_uploaded_file` function)');
                }
            } else {
                throw new Exception('The file is not uploaded (`is_uploaded_file` function)');
            }
        } else {
            throw new Exception('file upload error #' . $file['error']);
        }
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
                
                // upload the file
                $returnValue = $this->_uploadFile($file);
            }
        } catch (Exception $e) {
            fputs(STDERR, $e->getMessage());
        }

        // return the previous value
        return $returnValue;
    }

}