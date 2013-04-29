<?php

/**
 * One table class
 */
// The view file of the page
define('GALLERY_VIEW', VIEWS_DIR . '/Table/Gallery.view.php');
define('GALLERY_CSS', VIEWS_DIR . '/Table/Gallery.css');

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

    /**
     * 
     * @param type $galleryPkValue
     * @return null
     */
    protected function _getImagesFromGallery($galleryPkValue) {

        $db = Database::getInstance();
        try {
            $stmt = $db->prepare('
            select * 
            from `' . $this->_imagesTable . '` 
            where `' . $this->_imagesTableReferenceField . '` = :' . $this->_imagesTableReferenceField
            );

            $stmt->bindValue(':' . $this->_imagesTableReferenceField, $galleryPkValue);
            $stmt->execute();
            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            return null;
        }

        return $result;
    }

    /**
     * Receive ajax calls from the gallery actions
     */
    public function executeAjax() {

        // check if this is a request to get gallery images
        $req = Request::getInstance();
        if ($req->get('galleryTable') == $this->getDbName() && $req->get('pk')) {
            $result = $this->_getImagesFromGallery($req->get('pk'));
            die(json_encode(array('result' => 'ok', 'images' => $result)));
        }

        parent::executeAjax();
    }

    
    public function getHtml() {
        $html = parent::getHtml();
        
        $html.= '<div id="gallery-images"></div>';
        return $html;
    }
    
    public function getCss() {
        $css = parent::getCss();
        
        ob_start();
        require GALLERY_CSS;
        $css.= ob_get_clean();
        
        return $css;
    }
}