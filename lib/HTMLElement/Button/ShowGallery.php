<?php

/**
 * Description of a file
 * 
 * @since Mar 19, 2013
 * @author Gregoryc
 */
define('GALLERY_JS', VIEWS_DIR . '/Table/Gallery.js');

class Button_ShowGallery extends Button {

    /**
     * avoid from including the JS several times
     * @var bool 
     */
    protected static $_javascriptIncluded = null;
    
    /**
     * The table this button is in
     * @var type 
     */
    protected $_table = null;

    /**
     * 
     * @return string
     */
    public function getHtml() {
        return '<a class="btn" button-operation="show-gallery" table-db-name="' . (is_null($this->getTable()) ? '' : $this->getTable()->getDbName()) . '">' .
                '<i class="icon-th"></i> Show gallery' .
                '</a>';
    }

    /**
     * Get the javascript that operates the button
     */
    public function getJavascript() {
        
        if (self::$_javascriptIncluded) {
            return '';
        }
        
        // let the application include the 
        self::$_javascriptIncluded = true;
        
        ob_start();
        require GALLERY_JS;
        return ob_get_clean();
    }

}