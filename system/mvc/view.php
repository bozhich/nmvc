<?php
/**
 * View
 *
 *
 * @package		system
 * @subpackage	mvc
 * @author		Luka Bozhich <luka@bozhich.com>
 */
namespace system\mvc;

use system\Singleton,
system\Request;

class View extends Singleton {

	/**
	 * @access static
	 * @var File Extension
	 */
	const FILE_EXT = '.php';
	
	/**
	 * @access protected
	 * @var Requests
	 */
	protected $request;
	
	/**
	 * @access protected
	 * @var data
	 */
	protected $data;
	
	/**
	 * @access protected
	 * @var Layout
	 */
	protected $layout = 'layout';
	
	/**
	 * @access protected
	 * @var View File
	 */
	protected $view_file;
	
	/**
	 * @access protected
	 * @var Disable Layout
	 */
	protected $disable_layout = false;

	
	/**
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->request = Request::getInstance();
	}
	
	
	/**
	 * Launches the View
	 * @access public
	 * @return void
	 */
	public function fire() {
		$this->_include($this->layout);
	}
	
	
	/**
	 * Displayes Main File
	 * @access public
	 * @return void
	 */
	public function displayMain() {
		if ($this->disable_layout) {
			return false;
		}
		
		if (!isset($this->view_file)) {
			$this->view_file = $this->request->getRoute('controller') . '.' . $this->request->getRoute('method');
		}
		
		$this->_include($this->view_file);
	}
	
	
	/**
	 * sets a different Main File
	 * @access public
	 * @param string $file 
	 * @return void
	 */
	public function setMainFile($file) {
		$this->view_file = $file;
	}
	
	/**
	 * Disables Layout
	 * @access public
	 * @return void
	 */
	public function disableLayout() {
		$this->disable_layout = true;
	}
	
	
	/**
	 * Enables Main File
	 * @access public
	 * @return void
	 */
	public function enableLayout() {
		$this->disable_layout = false;
	}
	

	/**
	 * Includes a file
	 * @access protected
	 * @return void
	 */
	protected function _include($file) {
		$file_loc = \Paths::APP_PATH . DS . 'views' . DS . $this->pharseName($file) . self::FILE_EXT;
		if (file_exists($file_loc)) {
			include $file_loc;
			return;
		}
		
		throw new \Exception('file ' . $file . ' does not exist');
	}
	
	
	/**
	 * pharses a file name to match a view patterns
	 * @access protected
	 * @param string $file
	 * @return string
	 */
	protected function pharseName($file) {
		return str_replace(".", DS, $file);
	}
	
	
	/**
	 * @access public
	 * @param string $var
	 * @return string bool
	 */
	public function __get($var) {
		return (array_key_exists($var, $this->data)) ? $this->data[$var] : null;
	}

	
	/**
	 * @access public
	 * @param string $file
	 * @param string $value
	 * @return void
	 */
	public function __set($var, $value) {
		$this->data[$var] = $value;
	}
	
	
	/**
	 * get the adress of the static server described in the config
	 * @access public
	 * @return string
	 */
	public function getStaticAddress() {
		return \system\Config::get('static_address');
	}
}