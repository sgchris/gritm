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
	 * Add order by clause item
	 * can be called several times (appends the order)
	 * @param $fieldName
	 * @param $fieldOrder - Field::ORDER_ASCENDING / Field::ORDER_DESCENDING
	 * @return $this
	 */
	public function orderBy($fieldName, $fieldOrder = Field::ORDER_ASCENDING) {
		// get the current order
		$order = $this->getOrder();

		// add the new order
		$order[] = array(
			'key'=>$fieldName,
			'order'=>$fieldOrder
			);

		$this->setOrder($order);
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

	/**
	 * Get the sql for the table (custom or native)
	 */
	private function _getSql() {

		// get the custom URL if defined
		$sql = $this->getCustomSql();
		if (!empty($sql)) {
			return $sql;
		}

		// build the sql //

		// select clause
		$sql_Select = array($this->getPkField());
		array_walk($this->getItems(), function($item) use (&$sql_Select) {
			if ($item instanceof Field) {
				$sql_Select[] = $item->getDbName();
			}
		});

		// from clause
		$sql_From = array($this->getDbName());

		// where clause
		$sql_Where = array();
		array_walk($this->getExtraConditions(), function($item) use (&$sql_Where) {
			$sql_Where[] = '`'.$item['key'].'` '.$item['operator'].' :'.$item['key'];
		});

		// order by clause
		$sql_Order = array();
		array_walk($this->getOrder(), function($item) use (&$sql_Order) {
			$sql_Order[] = '`'.$item['key'].'` '.($item['key'] == Table::ORDER_ASCENDING ? 'ASC' : 'DESC');
		});

		// limit clause
		// TODO: manage paging
		$sql_Limit = array($this->getTotalRows());

		$sql = '
			SELECT '.implode(',', $sql_Select).'
			FROM '.implode(',', $sql_From).'
			WHERE ('.implode(') AND (', $sql_Where).')
			ORDER BY '.implode(',', $sql_Order).'
			LIMIT '.implode(',', $sql_Limit);

		// prepare

		// bind values
	}
}