<?php

// include the application config
if (!file_exists(__DIR__ . '/lib/gritm.php')) {
    die('The file '. __DIR__ . '/lib/gritm.php' . ' does not exist');
}
require_once __DIR__ . '/lib/gritm.php';

// include the application index
if (!file_exists(__DIR__ . '/app/index.php')) {
    die('The file '. __DIR__ . '/app/index.php' . ' does not exist');
}
require_once __DIR__ . '/app/index.php';
