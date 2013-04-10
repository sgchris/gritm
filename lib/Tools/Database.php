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

    /**
     * Insert a record to the database
     * @param type $tableName
     * @param type $fields
     */
    public function insert($tableName, $fields) {
        
    }
    
    /**
     * Update a record in the database
     * @param type $tableName
     * @param type $fields
     * @param type $whereFields
     */
    public function update($tableName, $fields, $whereFields) {
        
    }
    
    /**
     * Delete a record from the database
     * @param type $tableName
     * @param type $whereFields
     */
    public function delete($tableName, $whereFields) {
        
    }
}