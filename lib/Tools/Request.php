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