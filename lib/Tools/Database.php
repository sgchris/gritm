<?php
 
/**
 * PDO SINGLETON CLASS
 */ 
class Db 
{  
	/**
	 * The singleton instance
	 */
	protected static $PDOInstance = null; 
	
	/**
	 * Credentials
	 */
	const username = 'root';
	const password = '123456';

	/**
	 * DB info
	 */
	const host = 'localhost';
	const dbName = 'gritm';

	/**
	 * get database instance
	 * @throws Exception
	 */
	public static function get() {
		if (is_null(self::$PDOInstance)) {
			self::$PDOInstance = new PDO('mysql:host='.(Db::host).';dbname='.(Db::dbName), Db::username, Db::password);
			self::$PDOInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
			self::$PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); 
			self::$PDOInstance->exec('set names "utf8"'); 
			self::$PDOInstance->exec('set character set "utf8"');
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