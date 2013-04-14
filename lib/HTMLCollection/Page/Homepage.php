<?php

/**
 * instance of Page class - responsible for the homepage
 */

// The homepage HTML
define('HOMEPAGE_VIEW', VIEWS_DIR . '/Application.homepage.view.php');

class Page_Homepage extends Page {

    /**
     * @override the basic page constructor
     * @param type $pageName
     * @param type $pageUrl
     */
    public function __construct($pageName = 'Homepage', $pageUrl = '') {
        parent::__construct($pageName, $pageUrl);
    }

    /**
     * Get the HTML of the homepage
     * @return type
     */
    public function getHtml() {
        ob_start();
        require HOMEPAGE_VIEW;
        return ob_get_clean();
    }

}