<?php
/**
 * Main App class
 */

require_once __DIR__ . '/../Collection.php';
require_once __DIR__ . '/../Tools/Request.php';

class Application extends Collection {

	/**
	 * The name of the application
	 */
	private $name;

	/**
	 * enable/disable layout. default true. 
	 * e.g. false is used for AJAX requests 
	 */
	private $layoutEnabled = true;

	/**
	 * disable layout - (for ajax requests for example)
	 */
	public function disableLayout() {
		$this->layoutEnabled = false;
	}

	/**
	 * Initialize application object
	 */
	public function __construct($applicationName = 'Unnamed application') {

		// initialize the name of the application
		$this->name = $applicationName;

		// get the request object for the current request
		$this->_request = new Request;
	}

	/**
	 * Execute the application
	 */
	public function run() {

		// determine which object the current request belongs
		$currentPage = null;

		// perform "polling" to get who can manage this request
		foreach ($this->getItems() as $item) {
			if (($item instanceof Page) && $item->isResponsibleFor($this->_request)) {
				$currentPage = $item;
				break;
			}
		}

		// load the HTML of the page
		$pageHtml = $currentPage instanceof Page ? $currentPage->getHtml($this->_request) : $this->_getHomepage();

		// load the page
		if ($this->layoutEnabled) {
			echo Layout::getHtml($pageHtml);
		} else {
			echo $pageHtml;
		}
	}

	private $_request = null;

}