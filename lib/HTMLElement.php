<?php

/**
 * HTML Element base class
 */
// include the global configuration file
require_once __DIR__ . '/Config/Config.php';

class HTMLElement {

    /**
     * The name of the element
     * @var string
     */
    protected $_name;

    /**
     * The description of the element
     * @var string
     */
    protected $_description;

    /**
     * The html of the element
     * @var string
     */
    protected $_html;

    /**
     * The css of the element
     * @var string
     */
    protected $_css;

    /**
     * The Javascript of the element
     * @var string
     */
    protected $_javascript;

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
     * add css to the current css
     * @param $css string
     * @return this object
     */
    protected function appendCss($css) {
        $this->_css.=$css;
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

        if (method_exists($this, $funcName)) {
            return call_user_func_array(array($this, $funcName), $args);
        }
        
        throw new Exception(__METHOD__ . ': error calling "' . $funcName . '" function');
    }

}