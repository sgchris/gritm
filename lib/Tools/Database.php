<?php

require_once __DIR__ . '/../Config/Config.php';

/**
 * PDO SINGLETON CLASS
 */
class Database extends PDO {

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
                self::$PDOInstance = new Database('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
                self::$PDOInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    public function __construct($dsn, $username, $passwd, array $options = array()) {
        parent::__construct($dsn, $username, $passwd, $options);
        // empty constructor
    }

    /**
     * Insert a record to the database
     * @param type $tableName
     * @param type $fields
     */
    public function insert($tableName, array $fields) {
        try {
            if (empty($fields)) {
                throw new Exception('error : no fields parameters in ' . __METHOD__);
            }

            // get the list of fields (names)
            $fieldNames = array();
            $values = array();
            foreach (array_keys($fields) as $fieldName) {
                $fieldNames[] = '`' . $fieldName . '`';
                $values[] = ':' . $fieldName;
            }

            // create the SQL string
            $sql = 'insert into `' . $tableName . '` (' . implode(',', $fieldNames) . ') values (' . implode(',', $values) . ')';

            // bind values
            $db = self::getInstance();
            $stmt = $db->prepare($sql);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            // execute the query
            $stmt->execute();
            return $db->lastInsertId();
        } catch (Exception $e) {
            debug_print_backtrace();
            return null;
        }
    }

    /**
     * Update a record in the database
     * @param type $tableName
     * @param type $fields
     * @param type $whereFields
     */
    public function update($tableName, array $fields, array $whereFields) {
        if (empty($fields)) {
            throw new Exception('error : no fields parameters in ' . __METHOD__);
        }

        // create fields counter in case where the same field is in SET and in WHERE
        $fieldsCoutner = 0;

        // init the sql string
        $sql = "update `$tableName` set ";

        // gather "SET" sql section variables
        $setValues = array();
        foreach (array_keys($fields) as $fieldName) {
            $setValues[] = '`' . $fieldName . '` = :' . $fieldName . ($fieldsCoutner++);
        }

        // add the "SET" clause to the SQL
        $sql .= implode(',', $setValues);

        // build the 'where' clause
        $whereConds = array();
        foreach (array_keys($whereFields) as $fieldName) {
            $whereConds[] = '`' . $fieldName . '` = :' . $fieldName . ($fieldsCoutner++);
        }

        if (!empty($whereConds)) {
            $sql .= ' WHERE (' . implode(') AND (', $whereConds) . ')';
        }

        // prepare the statement
        $db = self::getInstance();
        $stmt = $db->prepare($sql);

        // bind values for the SET
        $fieldsCoutner2 = 0;
        foreach ($fields as $fieldName => $fieldValue) {
            $stmt->bindValue(':' . $fieldName . ($fieldsCoutner2++), $fieldValue);
        }

        // bind values for the WHERE
        foreach ($whereFields as $fieldName => $fieldValue) {
            $stmt->bindValue(':' . $fieldName . ($fieldsCoutner2++), $fieldValue);
        }

        // execute the query
        $stmt->execute();
        return $this;
    }

    /**
     * Delete a record from the database
     * @param type $tableName
     * @param type $whereFields
     */
    public function delete($tableName, array $whereFields) {

        // get the list of fields (names)
        $sql = 'delete from `' . $tableName . '`';

        // build the 'where' clause
        $whereConds = array();
        foreach (array_keys($whereFields) as $fieldName) {
            $whereConds[] = '`' . $fieldName . '` = :' . $fieldName;
        }
        // create the SQL string
        if (!empty($whereConds)) {
            $sql.= ' where (' . implode(') and (', $whereConds) . ')';
        }

        // prepare the statement
        $db = self::getInstance();
        $stmt = $db->prepare($sql);

        // bind values for the WHERE
        foreach ($whereFields as $fieldName => $fieldValue) {
            $stmt->bindValue(':' . $fieldName, $fieldValue);
        }

        // execute the query
        $stmt->execute();
        return $this;
    }

}