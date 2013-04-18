<?php

/**
 * Collection base class
 */
class HTMLCollection extends HTMLElement {

    /**
     * The html of the element
     * @var array
     */
    protected $items = array();

    /**
     * enable/disable layout. default true. 
     * e.g. false is used for AJAX requests 
     * @var bool
     */
    protected $_layoutEnabled = true;

    /**
     * disable layout - (for ajax requests for example)
     * @alias $app->setLayoutEnabled(false)
     */
    public function disableLayout() {
        $this->_layoutEnabled = false;
        return $this;
    }

    /**
     * Add item to the collection
     * @param required $item
     * @param optional $key
     * @return this object
     */
    public function add($item, $key = null) {
        if (!$item)
            throw new Exception(__METHOD__ . ' - $item is not defined');
        if (!is_null($key) && empty($key))
            throw new Exception(__METHOD__ . ' - $key is not valid');

        if (is_null($key)) {
            $this->items[] = $item;
        } else {
            $this->items[$key] = $item;
        }

        return $this;
    }

    /**
     * Remove item from the collection (if the item exists)
     * @param required $key
     * @return this object
     */
    public function remove($key) {
        if (!array_key_exists($key, $this->items)) {
            throw new Exception(__METHOD__ . ' - $key is not defined');
        }

        unset($this->items[$key]);
        return $this;
    }

    /**
     * Set specific item in the collection
     * @param required $item
     * @param required $key
     * @return this object
     */
    public function set($item, $key) {
        if (!$item)
            throw new Exception(__METHOD__ . ' - $item is not defined');
        if (!$key)
            throw new Exception(__METHOD__ . ' - $key is not defined');
        $this->add($item, $key);

        return $this;
    }

    /**
     * Get item from the collection
     * @param required $key
     * @return item
     */
    public function get($key) {
        if (!array_key_exists($key, $this->items)) {
            throw new Exception(__METHOD__ . ' - $key is not defined');
        }

        return $this->items[$key];
    }

    /**
     * Get item from the collection
     * @return all the items in the collection
     */
    public function getAll() {
        return $this->items;
    }

    /**
     * @alias to `getAll`
     */
    public function getItems() {
        return $this->getAll();
    }

    /**
     * Check if the key exists
     * @param required $key
     * @return true/false
     */
    public function exists($key) {
        if (!$key)
            throw new Exception(__METHOD__ . ' - $key is not defined');
        return isset($this->items[$key]);
    }

}