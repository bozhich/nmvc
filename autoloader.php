<?php
/**
 * Autoloader
 *
 *
 * @package    Global
 * @author     Luka Bozhich <luka@bozhich.com>
 */
class Autoloader {

	/**
	 * load class file by it's full name
	 *
	 * @param string $class
	 * @return void
	 */
	public static function load($class) {
		
		// Linux Directory Separator 
		if (strtoupper(substr(PHP_OS, 0, 5)) === 'LINUX') {
			$class = implode(DS , explode('\\' , $class));
		}
		
		$filename = __DIR__ . DS . strtolower($class).'.php';
		if (file_exists($filename)) {
			include_once $filename;
		}
	}
}