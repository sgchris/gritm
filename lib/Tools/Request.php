<?php

/**
 * manage the request
 */
class Request {

    /**
     *
     * @var Request instance
     */
    protected static $_instance = null;
    
    /**
     * 
     * @return Request object
     */
    public static function getInstance($forceNewInstance = false) {
        if (is_null(self::$_instance) || $forceNewInstance) {
            self::$_instance = new Request();
            self::$_instance->parse();
        }
        
        return self::$_instance;
    }
    
    
    /**
     * the base dir of the app (relative path)
     * The value has to be changed when moving the file (Request.php) to another location
     */
    protected $_APP_BASE_DIR;

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
     * parsed URL request. /path/to/page
     * $urlParams = array('0'=>'path', '1'=>'to', '2'=>'url')
     */
    protected $_urlParams = null;

    /**
     * The relative path from doc root (`htdocs` or `www` dir)
     */
    protected $_relativePath = null;

    /**
     * get GET parameter / all GET parameters
     */
    public function get($idx = null) {
        if (is_null($idx)) {
            return $this->_get;
        } else {
            return isset($this->_get[$idx]) ? $this->_get[$idx] : null;
        }
    }

    /**
     * get POST parameter / all POST parameters
     */
    public function post($idx = null) {
        if (is_null($idx)) {
            return $this->_post;
        } else {
            return isset($this->_post[$idx]) ? $this->_post[$idx] : null;
        }
    }

    /**
     * get FILES specific item
     */
    public function file($idx) {
        return isset($this->_files[$idx]) ? $this->_files[$idx] : null;
    }

    /**
     * get all FILES 
     */
    public function files() {
        return $this->_files;
    }

    /**
     * determine if the current request is AJAX
     */
    protected $_isAjax = false;

    /**
     * determine if the current request is POST
     */
    protected $_isPost = false;

    /**
     * initialize the request object
     * - Parse the current request (_POST | _GET | _FILES)
     * - check of the request is AJAX
     */
    protected function __construct() {
        $this->_get = $_GET;
        $this->_post = $_POST;
        $this->_files = $_FILES;

        // set the base APP dir
        $this->_APP_BASE_DIR = __DIR__ . '/../..';

        // check if this is an AJAX call
        $this->_isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);
        // check if this is a post call (form submit)
        $this->_isPost = ($_SERVER['REQUEST_METHOD'] == 'POST');
    }

    /**
     * determine if the current request is AJAX
     */
    public function isAjax() {
        return $this->_isAjax;
    }

    /**
     * determine if the current request is AJAX
     */
    public function isPost() {
        return $this->_isPost;
    }

    /**
     * parse URL request. /path/to/page
     * $urlParams = array('0'=>'path', '1'=>'to', '2'=>'url')
     */
    public function parse() {
        $uri = $_SERVER['REQUEST_URI'];

        // remove the request GET parameters 
        $uri = ($qMarkPos = strpos($uri, '?')) !== false ? substr($uri, 0, $qMarkPos) : $uri;

        // remove the leading base path
        $uri = str_replace($this->getRelativePath(), '', $uri);

        // remove slashes
        $uri = trim($uri, '/');

        $this->_urlParams = explode('/', $uri);
    }

    /**
     * Get URL param. When the request is /path/to/file. 0->path 1->to 2->file
     * @param number $number - index of the 
     */
    public function getUrlParam($number) {
        if (is_null($this->_urlParams)) {
            $this->parse();
        }

        return isset($this->_urlParams[$number]) ? $this->_urlParams[$number] : null;
    }

    /**
     * Get the relative path from doc root (`htdocs` or `www` dir)
     */
    public function getRelativePath() {

        if (is_null($this->_relativePath)) {

            // get app path and the docRoot path
            $docRoot = realpath($_SERVER['DOCUMENT_ROOT']);

            // get the base dir for the app
            $baseDir = realpath($this->_APP_BASE_DIR);

            // substruct the base path from the app path
            $baseDir = substr($baseDir, strlen($docRoot));

            // convert win slashes to URL slashes
            $baseDir = str_replace('\\', '/', $baseDir);

            // remove the trailing slash
            $baseDir = rtrim($baseDir, '/');

            // assign the base dir to the local var
            $this->_relativePath = $baseDir;
        }

        return $this->_relativePath;
    }

}