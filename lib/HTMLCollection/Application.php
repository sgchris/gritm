<?php
/**
 * Main App class
 */

require_once __DIR__ . '/../HTMLCollection.php';
require_once __DIR__ . '/../Tools/Request.php';

// all the view files
define('VIEWS_DIR', __DIR__.'/../Views');
// The view file of the application
define('APP_VIEW', VIEWS_DIR.'/Application.view.php');
// The homepage HTML
define('HOMEPAGE_VIEW', VIEWS_DIR.'/Application.homepage.view.php');

class Application extends HTMLCollection {

	/**
	 * The name of the application
	 */
	private $_name;

	/**
	 * the request object
	 * initialized by `Request` object
	 */
	private $_request = null;

	/**
	 * The HTML of the inner page (output from `Page` object)
	 */
	protected $_html = '';

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
		$this->_name = $applicationName;

		// get the request object for the current request
		$this->_request = new Request;
		$this->_request->parse();
	}

	/**
	 * Execute the application
	 */
	public function run() {

		// get the current page (page which processes this request)
		$currentPage = $this->_getCurrentPage();
		if (!$currentPage) {
			$currentPage = new Homepage;
		}

		// set the request object to the page
		$currentPage->setRequest($request);

		// check if this is AJAX request
		if ($this->_request->isAjax()) {

			// execute the ajax functions
			$currentPage->executeAjax();
			
		} else {

			// get the html of the page
			$this->_html = $currentPage->getHtml()

			// load the page
			if ($this->layoutEnabled) {
				$this->_renderLayout();
			}

			// output the app HTML
			echo $this->_html;

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
	 * Wrap the current _html ($this->_html) with the layout (views/application.view.php)
	 */
	protected function _renderLayout() {
		ob_start();
		require APP_VIEW;
		$this->_html = ob_get_clean();
	}

}