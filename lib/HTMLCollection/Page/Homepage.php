<?php
/**
 * instance of Page class - responsible for the homepage
 */

require_once __DIR__.'/../Page.php';

// The homepage HTML
define('HOMEPAGE_VIEW', VIEWS_DIR.'/Application.homepage.view.php');

class Homepage extends Page {

	public function getHtml() {
		ob_start();
		require HOMEPAGE_VIEW;
		return ob_get_clean();
	}

}