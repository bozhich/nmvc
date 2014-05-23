<?php
/**
 * Config
 *
 *
 * @package    system
 * @author     Luka Bozhich <luka@bozhich.com>
 */

namespace system;

use system\Database\db as DB;

class Config {
	
	/**
	 * @access public
	 * @static
	 * @var array
	 */
	public static $application = array();
	
	/**
	 * @access public
	 * @static
	 * @var database
	 */
	public static $database = array();

	
	/**
	 * Loads user configuration
	 * @access public
	 * @static
	 * @return void
	 */
	public static function load() {
		self::$application = require \Paths::CFG_PATH . 'application.php';
		self::$database = require \Paths::CFG_PATH . 'database.php';
	}

	
	/**
	 * Connects to Database
	 * @access public
	 * @static
	 * @return void
	 */
	public static function loadDb() {
		DB::init(self::$database);
	}


	/**
	 * gets and config value
	 * @access public
	 * @static
	 * @return string
	 */
	public static function get($var) {
		return self::$application[$var];
	}
}