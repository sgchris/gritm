<?php
/**
 * One table class
 */

require_once __DIR__ . '/../HTMLElement.php';
require_once __DIR__ . '/../HTMLElement/Field.php';
require_once __DIR__ . '/../HTMLElement/Button.php';

// The view file of the page
define('TABLE_VIEW', VIEWS_DIR.'/Table.view.php');

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
	 * add condition to the sql
	 * @param $key
	 * @param $val
	 * @param $operator default "=" (available "in", "like", etc)
	 * @return $this
	 */
	public function addExtraCondition($key, $val, $operator = '=') {
		$this->_extraConditions[] = array(
			'key'=>$key,
			'val'=>$val,
			'operator'=>$operator
		);

		return $this;
	}

	/**
	 * Get the html of the table
	 */
	public function getHtml() {

		// get only the fields
		$fieldsList = array_filter($this->getItems(), function($item) {
			return ($item instanceof Field);
		});

		// get only the buttons
		$buttonsList = array_filter($this->getItems(), function($item) {
			return ($item instanceof Button);
		});

		// load page template
		ob_start();
		require TABLE_VIEW;
		$pageHtml = ob_get_clean();

		return $pageHtml;
	}

}