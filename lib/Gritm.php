<?php

/**
 * Initial page of the lib. This page is included in the application definition
 * 
 * @since Mar 17, 2013
 * @author Gregoryc
 */

// define the root dir of the application
define('GRITM_DIR', __DIR__);

// include the basic configuration
require_once __DIR__ . '/Config/Config.php';

/**
 * Define the default AUTOLOAD
 * @param type $className
 */
function __autoload($className) {

    $className = str_replace('_', '/', $className);
    $fileName = null;

    // check in ROOT
    if (file_exists(LIB_DIR . '/' . $className . '.php')) {
        $fileName = LIB_DIR . '/' . $className . '.php';
    }

    // check in TOOLS
    if (file_exists(LIB_DIR . '/Tools/' . $className . '.php')) {
        $fileName = LIB_DIR . '/Tools/' . $className . '.php';
    }

    // check in HTMLElement
    if (file_exists(LIB_DIR . '/HTMLElement/' . $className . '.php')) {
        $fileName = LIB_DIR . '/HTMLElement/' . $className . '.php';
    }

    // check in HTMLCollection
    if (file_exists(LIB_DIR . '/HTMLCollection/' . $className . '.php')) {
        $fileName = LIB_DIR . '/HTMLCollection/' . $className . '.php';
    }

    if (!is_null($fileName)) {
        require_once $fileName;
    }
}