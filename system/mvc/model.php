<?php
/**
 * Model
 *
 *
 * @package		system
 * @subpackage	mvc
 * @author		Luka Bozhich <luka@bozhich.com>
 */
namespace system\mvc;

use system\Database\ORM;

class Model extends ORM {

	/**
	 * @access protected
	 * @static
	 * @var Instances
	 */
	protected static $instances = array(); 

	
	/**
	 * gets a instance of the Database
	 * @access public
	 * @static
	 * @return object
	 */
	public static function getDb() {
		$called_class_name = get_called_class();
		
		if (!isset(self::$instances[$called_class_name])) {
			$model = ucfirst($called_class_name);
			
			if (class_exists($model)) {
				self::$instances[$called_class_name] = new $model();
			} else {
				$model = new \Error;
				return $model->index();
			}
		}
		return self::$instances[$called_class_name];		
	}
}
