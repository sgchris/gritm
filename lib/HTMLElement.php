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
	 * The css of the element
	 */
	private $_css;

	/**
	 * The Javascript of the element
	 */
	private $_javascript;

	/**
	 * Get the html of the element
	 */
	public function getHtml() {
		return $this->_html;
	}

	/**
	 * Get the css of the element
	 */
	public function getCss() {
		return $this->_css;
	}

	/**
	 * Get the javascript of the element
	 */
	public function getJavascript() {
		return $this->_javascript;
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

	/**
	 * add css to the current css
	 * @param $css string
	 * @return this object
	 */
	private function appendCss($css) {
		$this->_css.=$css;
		return $this;
	}

	/**
	 * set css to the current css
	 * @param $css string
	 * @return this object
	 */
	private function setCss($css) {
		$this->_css=$css;
		return $this;
	}

	/**
	 * add javascript to the current javascript
	 * @param $javascript string
	 * @return this object
	 */
	private function appendJavascript($javascript) {
		$this->_javascript.=$javascript;
		return $this;
	}

	/**
	 * set javascript to the current javascript
	 * @param $javascript string
	 * @return this object
	 */
	private function setJavascript($javascript) {
		$this->_javascript=$javascript;
		return $this;
	}

}