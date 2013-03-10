<?php
/**
 *	One page class
 */

require_once __DIR__ . '/../Collection.php';

class Page extends Collection {

	/**
	 * Check if the current object can process this request
	 */
	public function isResponsibleFor($request) {
		return false;
	}

}