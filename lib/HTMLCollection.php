<?php
/**
 *	Collection base class
 */

require_once __DIR__.'/HTMLElement.php';

class HTMLCollection extends HTMLElement {

	/**
	 * The html of the element
	 */
	private $items = array();

	/**
	 * Add item to the collection
	 * @param required $item
	 * @param optional $key
	 * @return this object
	 */
	public function add($item, $key = null) {
		if (!$item) throw new Exception(__METHOD__.' - $item is not defined');
		if (!is_null($key) && empty($key)) throw new Exception(__METHOD__.' - $key is not valid');

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
		if (!$key) throw new Exception(__METHOD__.' - $key is not defined');

		if ($this->exists($key)) {
			unset($this->items[$key]);
		}

		return $this;
	}

	/**
	 * Set specific item in the collection
	 * @param required $item
	 * @param required $key
	 * @return this object
	 */
	public function set($item, $key) {
		if (!$item) throw new Exception(__METHOD__.' - $item is not defined');
		if (!$key) throw new Exception(__METHOD__.' - $key is not defined');
		$this->add($item, $key);

		return $this;
	}

	/**
	 * Get item from the collection
	 * @param required $key
	 * @return item
	 */
	public function get($key) {
		if (!$key) throw new Exception(__METHOD__.' - $key is not defined');
		return $this->items[$itemNumber];
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
		if (!$key) throw new Exception(__METHOD__.' - $key is not defined');
		return isset($this->items[$key]);
	}

}