<?php
use system\Config,
system\Router,
//system\Request,
//system\Database\Query,
system\mvc\View,
system\mvc\Error;

require_once 'paths.php';

require_once ROOT_PATH . 'autoloader.php';
spl_autoload_register(array('Autoloader', 'load'));

/**
 * Load user configuration options
 */
Config::load();


/**
 * Development Setup
 */

if (Config::$application['environment'] == 'development') {
	error_reporting(E_ALL);
	ini_set('display_errors', true);
} else {
	set_error_handler(array('system\mvc\Error', 'errorHandler'));
	set_exception_handler(array('system\mvc\Error', 'exceptionHandler'));
}

/**
 * Connect to database
 */
Config::loadDb();


/**
 * Load router and get the application runnig
 */
Router::getInstance()->fire();

/**
 * Load the View
 */
View::getInstance()->fire();


//

function dd() {
	$args = func_get_args();
	foreach($args as $var) {
		\NDebugger::dump($var);
	}
	die();
}

function d() {
	$args = func_get_args();
	foreach($args as $var) {
		\NDebugger::dump($var);
	}
}

function bd() {
	$args = array_reverse(func_get_args());
	$title = '[dump]';
	foreach($args as $var) {
		if (is_string($var)) {
			if (preg_match('#\[(.*)\]#', $var)) {
				$title = $var;
				continue;
			}
		}
		\NDebugger::barDump($var, $title);
	}
}

