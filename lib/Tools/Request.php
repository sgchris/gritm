<?php
/**
 * manage the request
 */

class Request {
	
	/**
	 * local var for GET request parameters
	 */
	protected $_get;

	/**
	 * local var for POST request parameters
	 */
	protected $_post;

	/**
	 * local var for FILES request parameters
	 */	
	protected $_files;

	/**
	 * determine if the current request is AJAX
	 */	
	protected $_isAjax;

	/**
	 * initialize the request object
	 */
	public function __construct() {
		$this->_get = $_GET;
		$this->_post = $_POST;
		$this->_files = $_FILES;

		// determine wether this is an AJAX call
		$this->_isAjax = false; /////////////////////////////////////////// TODO!!!!!
	}	

	/**
	 * determine if the current request is AJAX
	 */	
	public function isAjax() {
		return $this->_isAjax;
	}

	/**
	 * Parse the current request (_POST | _GET | _FILES)
	 */
	public function parse() {

	}
}