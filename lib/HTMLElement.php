<?php
/**
 *	HTML Element base class
 */


class HTMLElement {

	/**
	 * The html of the element
	 */
	private $_html;

	/**
	 * Get the html of the element
	 */
	public function getHtml() {
		return $this->_html;
	}

	/**
	 * add html to the current html
	 * @param $html string
	 * @return this object
	 */
	private function appendHtml($html) {
		$this->_html.=$html;
		return $this;
	}

	/**
	 * set html to the current html
	 * @param $html string
	 * @return this object
	 */
	private function setHtml($html) {
		$this->_html=$html;
		return $this;
	}

}