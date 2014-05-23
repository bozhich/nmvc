<?php
/**
 * controller
 *
 *
 * @package		system
 * @subpackage	mvc
 * @author		Luka Bozhich <luka@bozhich.com>
 */
namespace system\mvc;

use system\Request;

abstract class Controller {
	
	/**
	 * gets the Request object
	 * @access protected
	 * @return object
	 */
	protected function getRequest() {
		return Request::getInstance();
	}
	
	
	/**
	 * gets the View object
	 * @access protected
	 * @return object
	 */
	protected function getView() {
		return View::getInstance();
	}
	
}
