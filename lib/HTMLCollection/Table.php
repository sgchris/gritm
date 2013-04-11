<?php

/**
 * One table class
 */
require_once __DIR__ . '/../HTMLElement.php';
require_once __DIR__ . '/../HTMLElement/Field.php';
require_once __DIR__ . '/../HTMLElement/Button.php';
require_once __DIR__ . '/../HTMLCollection.php';
require_once __DIR__ . '/../Tools/Database.php';

// The view file of the page
define('TABLE_VIEW', VIEWS_DIR . '/Table.view.php');

class Table extends HTMLCollection {
    /**
     * constants for sql order
     */

    const ORDER_ASCENDING = 1;
    const ORDER_DESCENDING = -1;

    /**
     * The name of the table (The top title)
     */
    protected $_name = null;

    /**
     * The name of the table in the database
     */
    protected $_dbName = null;

    /**
     * Primary key field name
     */
    protected $_pkField = 'id';

    /**
     * 
     * @param type $pkFieldName
     */
    public function setPkField($pkFieldName) {
        $this->_pkField = $pkFieldName;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getPkField() {
        return $this->_pkField;
    }

    /**
     * Primary key field name
     */
    protected $_pkFieldWidth = 50;

    /**
     * 
     * @param type $pkFieldWidth
     */
    public function setPkFieldWidth($pkFieldWidth) {
        $this->_pkFieldWidth = $pkFieldWidth;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getPkFieldWidth() {
        return $this->_pkFieldWidth;
    }

    /**
     * Alternative SQL for the table
     * if defined, there's no upsert available
     */
    protected $_customSql = null;

    /**
     * 
     * @param type $customSql
     */
    public function setCustomSql($customSql) {
        $this->_customSql = $customSql;
    }

    /**
     * 
     * @return string
     */
    public function getCustomSql() {
        return $this->_customSql;
    }

    /**
     * Additional conditions on the table (added to the SQL query)
     */
    protected $_extraConditions = array();

    /**
     * number of rows in one page
     */
    protected $_totalRows = 30;

    /**
     * 
     * @param type $totalRows
     */
    public function setTotalRows($totalRows) {
        $this->_totalRows = $totalRows;
        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getTotalRows() {
        return $this->_totalRows;
    }

    /**
     * Order of the query
     * format => array ('name'=>Table::ORDER_ASCENDING, 'date_created'=>Table::ORDER_DESCENDING)
     */
    protected $_order = array();

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
    public function addExtraCondition($key, $value, $operator = '=') {
        $this->_extraConditions[] = array(
            'key' => $key,
            'value' => $value,
            'operator' => $operator
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
            'key' => $fieldName,
            'order' => $fieldOrder
        );

        $this->setOrder($order);
        return $this;
    }

    /**
     * Get the html of the table
     */
    public function getHtml() {

        // get only the fields
        $fieldsList = $this->_getFields();

        // get only the buttons (if the layout enabled)
        $buttonsList = $this->_layoutEnabled ? $this->_getButtons() : array();

        // load the data
        $recordSetRows = $this->_getRecordSet();

        // load page template
        ob_start();
        require TABLE_VIEW;
        $pageHtml = ob_get_clean();

        return $pageHtml;
    }

    /**
     * 
     * @return string javascript code
     */
    public function getJavascript() {
        $jsCode = '
            [].forEach.call(document.querySelectorAll("tbody tr"), function(elem) {
                elem.onclick = function() {
                    // remove the currently selected row
                    var selectedRow = elem.parentNode.querySelector("tr.selected");
                    
                    if (selectedRow) selectedRow.classList.remove("info");
                    if (selectedRow) selectedRow.classList.remove("selected");

                    // add selected class to the chosen row
                    elem.classList.add("info");
                    elem.classList.add("selected");
                };
            });
            ';

        // get the javascript from the children elements
        foreach ($this->getItems() as $item) {
            if (method_exists($item, 'getJavascript')) {
                $jsCode.= $item->getJavascript();
            }
        }

        return $jsCode;
    }

    /**
     * @override
     * Execute ajax call of the page and its tables
     */
    public function executeAjax() {
        $req = Request::getInstance();

        // check if this is a request for "new" mode
        if ($req->get('table') == $this->getDbName() && $req->get('mode') == 'new') {
            $fields = array('result' => 'ok', 'fields' => array());

            foreach ($this->getItems() as $item) {
                if ($item instanceof Field) {
                    $fields['fields'][] = array(
                        'name' => $item->getName(),
                        'dbName' => $item->getDbName(),
                        'html' => $item->getNewHtml()
                    );
                }
            }

            echo json_encode($fields);
            return;
        }

        // check if this is a request for "new" mode
        if ($req->get('table') == $this->getDbName() && $req->get('mode') == 'edit' && $req->get('pk')) {
            $fields = array('result' => 'ok', 'fields' => array());

            $dbRow = $this->_getRow($req->get('pk'));
            if (!$dbRow) {
                
                $fields = array('result' => 'error', 'error' => 'Record not found');
            } else {

                foreach ($this->getItems() as $item) {
                    if ($item instanceof Field) {

                        // set the value of the field
                        $item->setValue($dbRow[$item->getDbName()]);

                        // get the HTML of the edit mode
                        $fields['fields'][] = array(
                            'name' => $item->getName(),
                            'dbName' => $item->getDbName(),
                            'html' => $item->getEditHtml()
                        );
                    }
                }
            }
            
            echo json_encode($fields);
            return;
        }
    }

    /**
     * Add new record to the database
     * @TODO implement the function
     */
    public function addRecord() {

        // define fields / values to be inserted to the database
        $fields = array();
        foreach ($this->getItems() as $item) {
            if ($item instanceof Field) {
                $fields[$item->getDbName()] = $item->getValueFromPost();
            }
        }

        // insert to the database
        $db = Database::getInstance();
        if ($db->insert($this->getDbName(), $fields) === false) {
            throw new Exception('Error inserting new record to the database');
        }
    }

    /**
     * update a record in the database
     * @TODO implement the function
     */
    public function updateRecord() {

        // determine if the request is relevant to the current table!
        $req = Request::getInstance();
        
        $pkValue = $req->get('pk');
        if (!$pkValue) {
            return false;
        }
        
        $db = Database::getInstance();
        $db->update($this->getDbName(), $req->post(), array($this->getPkField() => $pkValue));
    }

    /**
     * Get the fields within the table 
     * (instances of `Field`)
     */
    protected function _getFields() {

        // get only the fields
        $fieldsList = array_filter($this->getItems(), function($item) {
                    return ($item instanceof Field);
                });

        return $fieldsList;
    }

    /**
     * Get the buttons within the table 
     * (instances of `Field`)
     */
    protected function _getButtons() {

        // add button "add"
        $addButton = new Button_Add();
        $this->add($addButton);

        // add button "edit"
        $editButton = new Button_Edit();
        $this->add($editButton);

        // get only the buttons
        $buttonsList = array_filter($this->getItems(), function($item) {
                    return ($item instanceof Button);
                });

        // assign the table data to the buttons
        if (!empty($buttonsList)) {
            foreach ($buttonsList as $button) {
                $button->setTable($this);
            }
        }


        return $buttonsList;
    }

    /**
     * Get the sql for the table (custom or native)
     */
    protected function _getSql() {

        // get the custom URL if defined
        $sql = $this->getCustomSql();
        if (!empty($sql)) {
            return $sql;
        }



        // build the sql // 'select' clause
        $sql_Select = array('`' . $this->getPkField() . '`');
        $itemsList = $this->getItems();
        array_walk($itemsList, function($item) use (&$sql_Select) {
                    if ($item instanceof Field) {
                        $sql_Select[] = '`' . $item->getDbName() . '`';
                    }
                });

        // build the sql // 'from' clause
        $sql_From = array('`' . $this->getDbName() . '`');

        // build the sql // 'where' clause
        $sql_Where = array();
        $extraConditions = $this->getExtraConditions();
        array_walk($extraConditions, function($item) use (&$sql_Where) {
                    $sql_Where[] = '`' . $item['key'] . '` ' . $item['operator'] . ' :' . $item['key'];
                });

        // build the sql // order by clause
        $sql_Order = array();
        $order = $this->getOrder();
        array_walk($order, function($item) use (&$sql_Order) {
                    $sql_Order[] = '`' . $item['key'] . '` ' . ($item['order'] == Table::ORDER_ASCENDING ? 'ASC' : 'DESC');
                });

        // build the sql // 'limit' clause
        // TODO: manage paging
        $sql_Limit = array($this->getTotalRows());

        $sql = 'SELECT ' . implode(',', $sql_Select);
        $sql.= ' FROM ' . implode(',', $sql_From);

        if (!empty($sql_Where)) {
            $sql.= ' WHERE (' . implode(') AND (', $sql_Where) . ')';
        }

        if (!empty($sql_Order)) {
            $sql.= ' ORDER BY ' . implode(',', $sql_Order);
        }

        if (!empty($sql_Limit)) {
            $sql.= ' LIMIT ' . implode(',', $sql_Limit);
        }

        return $sql;
    }

    /**
     * Execute the query and return the results
     */
    protected function _getRecordSet() {

        // get the query
        $sql = $this->_getSql();

        // prepare the query
        try {
            if (($db = Database::get()) === null) {
                throw new Exception;
            }
        } catch (Exception $e) {
            return null;
        }
        $stmt = $db->prepare($sql);

        // bind values for the where clause
        foreach ($this->getExtraConditions() as $condition) {
            $stmt->bindValue(':' . $condition['key'], $condition['value']);
        }

        // execute the query
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Get a row from the database
     * @param type $pkValue
     */
    protected function _getRow($pkValue) {
        $db = Database::getInstance();
        $stmt = $db->prepare('select * from `' . $this->getDbName() . '` where `' . $this->getPkField() . '` = :' . $this->getPkField());
        $stmt->bindValue(':' . $this->getPkField(), $pkValue);
        $stmt->execute();
        return $stmt->fetch();
    }

}