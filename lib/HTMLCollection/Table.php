<?php
/**
 * One table class
 */

require_once __DIR__ . '/../HTMLCollection.php';

class Table extends HTMLCollection {

	/**
	 * constants for sql order
	 */
	const ORDER_ASCENDING = 1;
	const ORDER_DESCENDING = -1;

	/**
	 * The name of the table (The top title)
	 */
	private $_name = null;

	/**
	 * The name of the table in the database
	 */
	private $_dbName = null;

	/**
	 * Primary key field name
	 */
	private $_pkField = 'id';

	/**
	 * Alternative SQL for the table
	 * if defined, there's no upsert available
	 */
	private $_customSql = null;

	/**
	 * Additional conditions on the table (added to the SQL query)
	 */
	private $_extraConditions = array();

	/**
	 * number of rows in one page
	 */
	private $_totalRows = 30;

	/**
	 * Order of the query
	 * format => array ('name'=>Table::ORDER_ASCENDING, 'date_created'=>Table::ORDER_DESCENDING)
	 */
	private $_order = array();

	/**
	 * Initialize table
	 * @param $name
	 * @param $dbTableName - (optional) the name of the table in the database
	 * 						it has to be defined, unless customSql will defined
	 */
	public function __construct($name, $dbTableName = null) {
		$this->_name = $name;
		$this->_dbName = $dbTableName;
	}

	/**
	 * Generic set/get methods
	 */
	public function __call($funcName, $args) {

		// SET function
		if (preg_match('%^set%i', $funcName)) {
			$varName = '_'.lcfirst(preg_replace('%^set%i', '', $funcName));
			if (property_exists($this, $varName) && isset($args[0])) {
				$this->$varName = $args[0];
				return $this;
			}
		}

		// GET function
		if (preg_match('%^get%i', $funcName)) {
			$varName = '_'.lcfirst(preg_replace('%^get%i', '', $funcName));
			if (property_exists($this, $varName)) {
				return $this->$varName;
			}
		}

		throw new Exception(__METHOD__.': error calling "'.$funcName.'" function');
	}

	/**
	 * add condition to the sql
	 */
	public function addExtraCondition($key, $val, $operator = '=') {
		$this->_extraConditions[] = array(
			'key'=>$key,
			'val'=>$val,
			'operator'=>$operator
		);
	}

}