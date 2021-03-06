<?php
/**
 * DB
 * Extending DibiPHP http://dibiphp.com
 *
 * @package		system
 * @subpackage	database
 * @author		Luka Bozhich <luka@bozhich.com>
 */
namespace system\Database;

/**
 * Check PHP configuration.
 */
if (version_compare(PHP_VERSION, '5.2.0', '<')) {
	throw new Exception('dibi needs PHP 5.2.0 or newer.');
}

require_once dirname(__FILE__) . '/libs/interfaces.php';
require_once dirname(__FILE__) . '/libs/Dibi.php';
require_once dirname(__FILE__) . '/libs/DibiDateTime.php';
require_once dirname(__FILE__) . '/libs/DibiObject.php';
require_once dirname(__FILE__) . '/libs/DibiLiteral.php';
require_once dirname(__FILE__) . '/libs/DibiHashMap.php';
require_once dirname(__FILE__) . '/libs/DibiException.php';
require_once dirname(__FILE__) . '/libs/DibiConnection.php';
require_once dirname(__FILE__) . '/libs/DibiResult.php';
require_once dirname(__FILE__) . '/libs/DibiResultIterator.php';
require_once dirname(__FILE__) . '/libs/DibiRow.php';
require_once dirname(__FILE__) . '/libs/DibiTranslator.php';
require_once dirname(__FILE__) . '/libs/DibiDataSource.php';
require_once dirname(__FILE__) . '/libs/DibiFluent.php';
require_once dirname(__FILE__) . '/libs/DibiDatabaseInfo.php';
require_once dirname(__FILE__) . '/libs/DibiEvent.php';
require_once dirname(__FILE__) . '/libs/DibiFileLogger.php';
require_once dirname(__FILE__) . '/libs/DibiFirePhpLogger.php';

require_once dirname(__FILE__) . ('/Nette/Debugger.php');

if (interface_exists('Nette\Diagnostics\IBarPanel') || interface_exists('IBarPanel')) {
	require_once dirname(__FILE__) . '/bridges/Nette-2.1/DibiNettePanel.php';
}


class Db extends \dibi {
	/**
	 * @access private
	 * @static
	 * @var db
	 */
	private static $db = false;

	/**
	 * @param array $info
	 * @return \system\Database\db
	 */
	final public static function init($info) {
		if (!self::$db) {
			try {
				self::$db = \dibi::connect(array(
					'driver' => $info['driver'],
					'host' => $info['host'],
					'username' => $info['user'],
					'password' => $info['password'],
					'database' => $info['database'],
					'charset' => $info['charset'] ? $info['charset'] :'utf8',
					'result' => array(
						'detectTypes' => true,
						'formatDate' => "'Y-m-d'",
						'formatDateTime' => 'Y-m-d H:i:s',
					),
					'options'  => array(
						MYSQLI_OPT_CONNECT_TIMEOUT => 30
					),
					'profiler' => array(
						'run' => TRUE,
					),
						'flags'	=> MYSQLI_CLIENT_COMPRESS,
					)
				);
			} catch (DibiException $e) {
				self::$db = false;
				echo get_class($e), ': ', $e->getMessage(), "\n";
			}
		}
		return self::$db;
	}

}