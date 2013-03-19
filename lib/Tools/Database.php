<?php

require_once __DIR__ . '/../Config/Config.php';

/**
 * PDO SINGLETON CLASS
 */
class Database {

    /**
     * The singleton instance
     */
    protected static $PDOInstance = null;

    /**
     * get database instance
     * @throws Exception
     */
    public static function get() {
        if (is_null(self::$PDOInstance)) {
            try {
                self::$PDOInstance = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
                self::$PDOInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                self::$PDOInstance->exec('set names "utf8"');
                self::$PDOInstance->exec('set character set "utf8"');
            } catch (PDOException $e) {
                self::$PDOInstance = null;
            }
        }

        return self::$PDOInstance;
    }

    /**
     * @alias to get() method
     */
    public static function getInstance() {
        return self::get();
    }

    /**
     * protected constructor - singleton
     */
    protected function __construct() {
        // empty constructor
    }

}