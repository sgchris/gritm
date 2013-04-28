<?php

/**
 * One table class
 */
// The view file of the page
define('GALLERY_VIEW', VIEWS_DIR . '/Table/Gallery.view.php');
define('GALLERY_JS', VIEWS_DIR . '/Table/Gallery.js');

class Table_Gallery extends Table {

    public function __construct($name, $dbTableName = null) {
        
        // add the "show gallery" button above
        $this->add(new Button_ShowGallery());
        
        parent::__construct($name, $dbTableName);
    }
    
    /**
     * The name of the table with the images
     * @var string 
     */
    protected $_imagesTable = null;
    
    /**
     * The name of the field which points to the gallery record (in the galleries table)
     * @var string
     */
    protected $_imagesTableReferenceField = 'gallery_id';
    
    /**
     * define the table of the images, with the reference key
     * @param type $imagesTable
     * @param type $imagesTableReferenceField
     * @return \Table_Gallery
     */
    public function setImagesTable($imagesTable, $imagesTableReferenceField) {
        $this->_imagesTable = $imagesTable;
        $this->_imagesTableReferenceField = $imagesTableReferenceField;
        return $this;
    }

    /**
     * prevent loading the JS code more than once
     * @var boolean 
     */
    protected $javascriptLoaded = false;
    
    /**
     * Get the javascript
     * @return string
     */
    public function getJavascript() {
        
        if ($this->javascriptLoaded) {
            return '';
        } else {
            $this->javascriptLoaded = true;
        }
        
        ob_start();
        require_once GALLERY_JS;
        return ob_get_clean();
    }
}