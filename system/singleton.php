<?php
/**
 * Singleton
 *
 *
 * @package    system
 * @author     Luka Bozhich <luka@bozhich.com>
 */
namespace system;

class Singleton {
	
	/**
	* @access protected
	* @static
	* @var instances
	*/
	protected static $instances = array();
	
	
	/**
	 * @access protected
	 * @return void
	 */
	protected function __construct() {
		if (isset(self::$instances[get_called_class()])) {
			throw new \Exception('Class ' . get_called_class() . ' has already instanced');
		}
		self::$instances[get_called_class()] = $this;
	}
	
	
	/**
	 * Loads user configuration
	 * @access public
	 * @static
	 * @return Object | Instance of a class
	 */
	final public static function getInstance() {
		$called_class_name = get_called_class();
		
		if (!isset(self::$instances[$called_class_name])) {
			$controller = ucfirst($called_class_name);
			
			if (class_exists($controller)) {
				self::$instances[$called_class_name] = new $controller();
			} else {
				$controller = new \Error;
				return $controller->index();
			}
		}
		return self::$instances[$called_class_name];
	}
}