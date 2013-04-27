<?php

/**
 * One page class
 */
// include the required classes
// The view file of the page
define('PAGE_VIEW', VIEWS_DIR . '/Page.view.php');

class Page extends HTMLCollection {

    /**
     * The name/title of the page
     */
    protected $_name;

    /**
     * The url of the page
     */
    protected $_url = null;

    /**
     * The request object
     */
    protected $_request = null;

    /**
     * Set the icon of the page on the menu
     * All the icons can be viewed here:
     * @link http://twitter.github.io/bootstrap/base-css.html#icons 140 icons
     * @var type 
     */
    protected $_icon = 'icon-list-alt';

    /**
     * initialize the object
     */
    public function __construct($pageName, $pageUrl) {
        $this->_name = $pageName;
        $this->_url = $pageUrl;
    }

    /**
     * Check if the current object can process this request
     */
    public function isResponsibleFor(Request $request) {

        // store the current request
        $this->_request = $request;

        // check if the current URL (first URL param) equals this page's URL
        if (!is_null($this->_request) && strcasecmp($this->_request->getUrlParam(0), $this->_url) == 0) {
            return true;
        }

        return false;
    }

    /**
     * @override
     * Execute ajax call of the page and its tables
     */
    public function executeAjax() {

        // execute ajax of all the tables on the page
        foreach ($this->getItems() as $item) {

            if (method_exists($item, 'executeAjax')) {
                $item->executeAjax();
            }
        }
    }

    /**
     * Get the HTML of the page
     */
    public function getHtml() {

        // get the html of the tables
        $tablesHtml = '';
        foreach ($this->getItems() as $item) {

            // exclude buttons from the list
            if ($item instanceof Button)
                continue;

            // disable layout if needed
            if (!$this->_layoutEnabled && method_exists($item, 'disableLayout')) {
                $item->disableLayout();
            }

            // get the html of the table
            $tablesHtml.= $item->getHtml();
        }

        // get the html of the buttons if the layout enabled
        if (!$this->_layoutEnabled) {
            return $tablesHtml;
        } else {

            // load the page buttons
            $buttonsHtml = '';
            foreach ($this->getItems() as $item) {
                if (!($item instanceof Button))
                    continue;
                $buttonsHtml.= $item->getHtml();
            }

            // load page template
            ob_start();
            require PAGE_VIEW;
            $pageHtml = ob_get_clean();

            return $pageHtml;
        }
    }

    /**
     * 
     * @return string javascript code
     */
    public function getJavascript() {
        $jsCode = '';

        // get the javascript from the children elements
        foreach ($this->getItems() as $item) {
            if (method_exists($item, 'getJavascript')) {
                $jsCode.= $item->getJavascript();
            }
        }

        return $jsCode;
    }

    /**
     * Process POST request
     */
    public function processPost() {

        $req = Request::getInstance();

        // call the "processPost" method of the children
        foreach ($this->getItems() as $item) {

            // check if this is a table
            if ($item instanceof Table && $req->get('table') == $item->getDbName()) {

                if ($req->get('mode') == 'new') {
                    $item->addRecord();
                } elseif ($req->get('mode') == 'edit') {
                    $item->updateRecord();
                } elseif ($req->get('mode') == 'delete') {
                    $item->deleteRecord();
                }
            }
        }
    }

    /**
     * Check if one of the tables has wysiwyg.item
     * Used to check if the CKEditor has to be included
     * @return boolean
     */
    public function hasWysiwyg() {
        foreach ($this->getItems() as $item) {
            if ($item instanceof Table && $item->hasWysiwyg()) {
                return true;
            }
        }
        return false;
    }

}