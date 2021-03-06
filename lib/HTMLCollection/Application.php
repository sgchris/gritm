<?php

/**
 * Main App class
 */

// The view file of the application
define('APP_VIEW', VIEWS_DIR . '/Application.view.php');

class Application extends HTMLCollection {

    /**
     * the request object
     * initialized by `Request` object
     */
    protected $_request = null;

    /**
     * Current page
     */
    protected $_currentPage = null;

    /**
     * Initialize application object
     */
    public function __construct($applicationName = 'Unnamed application') {

        // initialize the name of the application
        $this->_name = $applicationName;

        // get the request object for the current request
        $this->_request = Request::getInstance();

        // add the homepage as one of the page
        $this->add(new Page_Homepage());
    }

    /**
     * Execute the application
     * @param $returnHtml - output or return the HTML of the application
     */
    public function run($returnHtml = false) {

        // get the current page (page which processes this request)
        $this->_currentPage = $this->_getCurrentPage();
        if (!$this->_currentPage) {
            $this->_currentPage = new Page_Homepage('Homepage', '');
        }

        // set the request object to the page
        $this->_currentPage->setRequest(Request::getInstance());

        // check if this is AJAX request
        if ($this->_request->isAjax()) {

            // execute the ajax functions
            $this->_executeAjax();
        } elseif ($this->_request->isPost()) {

            $this->_processPost();
        } else {

            // output the app HTML
            $entireCode = $this->getHtml();

            if ($returnHtml) {
                return $entireCode;
            } else {
                echo $entireCode;
            }
        }
    }

    /**
     * Get the page which can process the current request
     */
    protected function _getCurrentPage() {

        // determine which object the current request belongs
        $currentPage = null;

        // perform "polling" to get who can manage this request
        foreach ($this->getItems() as $item) {
            if (($item instanceof Page) && $item->isResponsibleFor($this->_request)) {
                $currentPage = $item;
                break;
            }
        }

        return $currentPage;
    }

    /**
     * Get the whole html of the application
     */
    public function getHtml() {

        // get only the `Page` objects from all the items (for the View)
        $applicationPages = array_filter($this->getItems(), function($item) {
                    return ($item instanceof Page);
                });

        // set the layout to the child items
        if (!$this->_layoutEnabled) {
            $this->_currentPage->disableLayout();
        }

        // get the HTML of the current page
        $currentPageHtml = $this->_currentPage ? $this->_currentPage->getHtml() : '';

        // get the Javascript if the layout enabled
        $currentPageJavascript = '';
        if (($jsCode = $this->getJavascript()) != '' && $this->_layoutEnabled) {
            $currentPageJavascript.= $jsCode;
        }

        // get the current page URL (for the View)
        $currentPageUrl = $this->_request->getUrlParam(0);
        if (is_null($currentPageUrl)) {
            $currentPageUrl = '';
        }

        // check if the layout is enabled, if no, just return the HTML of the current page
        if (!$this->_layoutEnabled) {

            // return only the inner page HTML
            return $currentPageHtml;
        } else {

            // load the application template
            ob_start();
            require APP_VIEW;
            return ob_get_clean();
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
     * @return string css code
     */
    public function getCss() {
        $cssCode = '';

        // get the javascript from the children elements
        foreach ($this->getItems() as $item) {
            if (method_exists($item, 'getCss')) {
                $cssCode.= $item->getCss();
            }
        }

        return $cssCode;
    }

    
    
    /**
     * Execute AJAX
     * @param Page $currentPage
     */
    protected function _executeAjax() {

        // Run ajax of the current requested page
        $this->_currentPage->executeAjax();
    }

    protected function _processPost() {
        // get the javascript from the children elements
        $this->_currentPage->processPost();
    }

}