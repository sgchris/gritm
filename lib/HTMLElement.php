<?php

/**
 * HTML Element base class
 */
// include the global configuration file
require_once __DIR__ . '/Config/Config.php';

class HTMLElement {

    /**
     * The html of the element
     */
    protected $_html;

    /**
     * The css of the element
     */
    protected $_css;

    /**
     * The Javascript of the element
     */
    protected $_javascript;

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
    protected function appendHtml($html) {
        $this->_html.=$html;
        return $this;
    }

    /**
     * set html to the current html
     * @param $html string
     * @return this object
     */
    protected function setHtml($html) {
        $this->_html = $html;
        return $this;
    }

    /**
     * add css to the current css
     * @param $css string
     * @return this object
     */
    protected function appendCss($css) {
        $this->_css.=$css;
        return $this;
    }

    /**
     * set css to the current css
     * @param $css string
     * @return this object
     */
    protected function setCss($css) {
        $this->_css = $css;
        return $this;
    }

    /**
     * add javascript to the current javascript
     * @param $javascript string
     * @return this object
     */
    protected function appendJavascript($javascript) {
        $this->_javascript.=$javascript;
        return $this;
    }

    /**
     * set javascript to the current javascript
     * @param $javascript string
     * @return this object
     */
    protected function setJavascript($javascript) {
        $this->_javascript = $javascript;
        return $this;
    }

    /**
     * execute ajax call
     */
    public function executeAjax() {
        
    }

    /**
     * Generic set/get methods
     * @return $this - in case of "set"
     */
    public function __call($funcName, $args) {

        // SET function
        if (preg_match('%^set%i', $funcName)) {
            $varName = '_' . lcfirst(preg_replace('%^set%i', '', $funcName));
            if (property_exists($this, $varName) && array_key_exists(0, $args)) {
                $this->$varName = $args[0];
                return $this;
            }
        }

        // GET function
        if (preg_match('%^get%i', $funcName)) {
            $varName = '_' . lcfirst(preg_replace('%^get%i', '', $funcName));
            if (property_exists($this, $varName)) {
                return $this->$varName;
            }
        }

        throw new Exception(__METHOD__ . ': error calling "' . $funcName . '" function');
    }

}