<?php
/**
 * Error Logger
 *
 *
 * @package    system
 * @subpackage mvc
 * @author     Luka Bozhich <luka@bozhich.com>
 */
namespace system\mvc;

class Error {
	const TYPE_APPLICATION = 1;
	const TYPE_EXCEPTION = 2;
	const TYPE_DB = 3;
	const TYPE_MISC = 4;

	protected static $files_prefix = array(
		self::TYPE_APPLICATION => 'error_application_',
		self::TYPE_EXCEPTION => 'error_exception_',
		self::TYPE_DB => 'error_db_',
		self::TYPE_MISC => 'error_misc_',
	);


	public static function save($type, $log) {
		$file_path = \Paths::LOGS_PATH . self::$files_prefix[$type] . date('Y-m-d') . '.log';

		$content = PHP_EOL . PHP_EOL;
		$content .= md5($log) . PHP_EOL;
		$content .= date('Y-m-d H:i:s') . ' ';
		$content .= preg_replace("[\n\r|\n]", '; ', is_array($log) ? var_export($log, true) : $log);

		$backtrace = debug_backtrace();
		for ($i = 0; $i < count($backtrace); $i++) {
			if (isset($backtrace[$i]['file'])) {
				$content .= PHP_EOL . "  FILE: " . $backtrace[$i]['file'] . ' (LINE: ' . $backtrace[$i]['line'] . ')';
			}
			$content .= PHP_EOL . "	FUNC: " . $backtrace[$i]['function'];
		}

		$content .= PHP_EOL . '>END ERROR';

		// @todo
		if (function_exists('cfg') && cfg()->dev_mode) {
			print '<pre style="background: black; color: white; margin: 10px; padding: 10px;">' . $content . '</pre>';
		}

		file_put_contents($file_path, $content, FILE_APPEND);
	}


	public static function errorHandler($type, $error) {
		self::save(self::TYPE_APPLICATION, $error);
	}


	public static function exceptionHandler($e) {
		self::save(self::TYPE_EXCEPTION, $e->getMessage());
	}
}
