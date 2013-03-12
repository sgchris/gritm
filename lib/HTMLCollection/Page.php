<?php
/**
 * One page class
 */

require_once __DIR__ . '/../Collection.php';
require_once __DIR__ . '/../Tools/Request.php';

class Page extends Collection {

	/**
	 * The name/title of the page
	 */
	private $_name;

	/**
	 * The url of the page
	 */
	private $_url = null;

	/**
	 * The request object
	 */
	private $_request = null;

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
		return false;
	}

	/**
	 * Set the request object to be handled by the page
	 */
	public function setRequest(Request $request) {
		$this->_request = $request;
		return $this;
	}


}