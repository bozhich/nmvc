<?php 
/**
 * DB
 *
 *
 * @package		system
 * @subpackage	database
 * @author		Luka Bozhich <luka@bozhich.com>
 */
namespace system\Database;

class DB {
	
	/**
	 * @access private
	 * @static
	 * @var db
	 */
	private static $db;
	
	/**
	 * @access private
	 * @var dbh
	 */
	private $dbh;

	
	/**
	 * @access public
	 * @static
	 * @var Info array
	 */
	public static function init(array $info) {
		try {
			self::$db = new \PDO( 
					$info['driver'].":dbname=".
					$info['database'].";host=".
					$info['host'],
					$info['user'], 
					$info['password']
			);

		} catch(\PDOException $e) {
			echo 'Connection failed: '. $e->getMessage()."\n";
			self::$db = null;
		}

	}

	
	private function __clone() {}

	
/*	public static function & instance() {
		if(!self::$db) {
			self::$db = new db;
		}
		return self::$db;
	}
*/
	
	/**
	 * @access public
	 * @static
	 * @var string $database 
	 */
	public static function changeDatabase($database) {
		self::instance()->exec('USE '.$database);
	}

	
	public function __call($method, $args = array()) {
		return call_user_func_array(array($this->dbh, $method), $args);
	}
	

	public static function __callStatic($method, $args = array()) {
		$db = self::instance();

		return call_user_func_array(array(self::$db, $method), $args);
	}
}
