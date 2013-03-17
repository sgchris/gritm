<?php
/**
 * One page class
 */

// include the required classes
require_once __DIR__ . '/../HTMLCollection.php';
require_once __DIR__ . '/Table.php';
require_once __DIR__ . '/../Tools/Request.php';

// The view file of the page
define('PAGE_VIEW', VIEWS_DIR.'/Page.view.php');

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
			if ($item instanceof Table) {
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
			if (!($item instanceof Table)) continue;

			$tablesHtml.= $item->getHtml();
		}

		// load page template
		ob_start();
		require PAGE_VIEW;
		$pageHtml = ob_get_clean();

		return $pageHtml;
	}

}