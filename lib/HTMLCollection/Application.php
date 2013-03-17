<?php

/**
 * Main App class
 */
require_once __DIR__ . '/../HTMLCollection.php';
require_once __DIR__ . '/Page/Homepage.php';
require_once __DIR__ . '/../Tools/Request.php';

// The view file of the application
define('APP_VIEW', VIEWS_DIR . '/Application.view.php');

class Application extends HTMLCollection {

    /**
     * The name of the application
     */
    protected $_name;

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
     * enable/disable layout. default true. 
     * e.g. false is used for AJAX requests 
     */
    protected $_layoutEnabled = true;

    /**
     * disable layout - (for ajax requests for example)
     * @alias $app->setLayoutEnabled(false)
     */
    public function disableLayout() {
        $this->_layoutEnabled = false;
    }

    /**
     * Initialize application object
     */
    public function __construct($applicationName = 'Unnamed application') {

        // initialize the name of the application
        $this->_name = $applicationName;

        // get the request object for the current request
        $this->_request = new Request;
        $this->_request->parse();
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
        $this->_currentPage->setRequest(new Request);
        // check if this is AJAX request
        if ($this->_request->isAjax()) {

            // execute the ajax functions
            $this->_executeAjax();
        } else {

            // output the app HTML
            $html = $this->getHtml();
            if ($returnHtml) {
                return $html;
            } else {
                echo $html;
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

        // get only the `Page` objects from all the items
        $applicationPages = array_filter($this->getItems(), function($item) {
                    return ($item instanceof Page);
                });

        // get the HTML of the current page
        $currentPageHtml = $this->_currentPage ? $this->_currentPage->getHtml() : '';

        // check if the layout is enabled, if no, just return the HTML of the current page
        if (!$this->_layoutEnabled) {
            return $currentPageHtml;
        }

        // load the application template
        ob_start();
        require APP_VIEW;
        return ob_get_clean();
    }

    /**
     * Execute AJAX
     * @param Page $currentPage
     */
    protected function _executeAjax() {

        // Run ajax of the current requested page
        $this->_currentPage->executeAjax();
    }

}