<?php
/**
 * Paths Describtion
 *
 *
 * @package	global
 * @author	 Luka Bozhich <luka@bozhich.com>
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('CFG_PATH', APP_PATH . 'config' . DS);
define('LIB_PATH', APP_PATH . 'libraries' . DS);
define('LOGS_PATH', ROOT_PATH . 'logs' . DS);

// not the best way to do this
class Paths {
	const ROOT_PATH = ROOT_PATH;
	const APP_PATH = APP_PATH;
	const CFG_PATH = CFG_PATH;
	const LIB_PATH = LIB_PATH;
	const LOGS_PATH = LOGS_PATH;
}