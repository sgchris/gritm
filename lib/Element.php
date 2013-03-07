<?php
/**
 *	Element base class
 */


class Element {

	/**
	 * The html of the element
	 */
	private $html;

	/**
	 * Get the html of the element
	 */
	public function getHtml() {
		return $this->html;
	}

	/**
	 * add html to the current html
	 * @param $html string
	 * @return this object
	 */
	protected function appendHtml($html) {
		$this->html.=$html;
		return $this;
	}

	/**
	 * set html to the current html
	 * @param $html string
	 * @return this object
	 */
	protected function setHtml($html) {
		$this->html=$html;
		return $this;
	}

}