<?php
/**
 * Request
 *
 *
 * @package	system
 * @author	 Luka Bozhich <luka@bozhich.com>
 */
namespace system;

class Request extends Singleton {

	/**
	 * Gets all the routes
	 * @access public
	 * @return array
	 */
	public function getRoutes() {
		return Router::getInstance()->getRoutes();
	}
	
	
	/**
	 * Gets a specific route
	 * @access public
	 * @param string $route
	 * @return string
	 */
	public function getRoute($route) {
		return Router::getInstance()->getRoute($route);
	}
	
	
	/**
	 * Gets a variable from $_SERVER if exist
	 * @access public
	 * @param string $var
	 * @return string
	 */
	public function getServer($var) {
		return (array_key_exists($var, $_SERVER)) ? $_SERVER[$var] : null;
	}	

	/**
	 * Gets all variables from $_SERVER
	 * @access public
	 * @return array
	 */
	public function getAllServers() {
		return $_SERVER;
	}
	
	
	/**
	 * Gets a variable from $_POST if exist
	 * @access public
	 * @param string $var
	 * @return string
	 */
	public function getPost($var) {
		return (array_key_exists($var, $_POST)) ? $_POST[$var] : null;
	}
	
	/**
	 * Gets all variables from $_POST
	 * @access public
	 * @return string
	 */
	public function getAllPosts() {
		return $_POST;
	}
	
	
	/**
	 * Gets a variable from $_GET if exist
	 * @access public
	 * @param string $var
	 * @return string
	 */
	public function getQuery($var) {
		return (array_key_exists($var, $_GET)) ? $_GET[$var] : null;
	}
	
	/**
	 * Gets all variables from $_GET
	 * @return string
	 */
	public function getAllQueries() {
		return $_GET;
	}
	
	
	/**
	 * Gets a variable from $_FILE if exist
	 * @access public
	 * @param string $file_id
	 * @return string
	 */
	public function getFile($file_id) {
		if (isset($_FILES[$file_id]) && is_file($_FILES[$file_id]['tmp_name'])) {
			$file = $_FILES[$file_id];
			$file['extension'] = strtolower(substr(strrchr($file['name'], '.'), 1));
		} else {
			$file = null;
		}
	
		return $file;
	}
	
	
	/**
	 * Gets a variable from $_COOKIE if exist
	 * @access public
	 * @param string $var
	 * @return string
	 */
	public function getCookie($var) {
		return (array_key_exists($var, $_COOKIE)) ? $_COOKIE[$var] : null;
	}
	
	
	/**
	 * Gets all variables from $_COOKIE
	 * @access public
	 * @return string
	 */
	public function getAllCookies() {
		return $_COOKIE;
	}
	
	
	/**
	 * Gets a variable from $_POST, $_GET, $_COOKIE, Route
	 * @access public
	 * @param string $var
	 * @return string
	 */
	public function getParam($var) {
		$param = $this->getPost($var);
		if (isset($param)) {
			return $param;
		}
	
		$param = $this->getQuery($var);
		if (isset($param)) {
			return $param;
		}
	
		$param = $this->getCookie($var);
		if (isset($param)) {
			return $param;
		}
	
		$param = $this->getRoute($var);
		if (isset($param)) {
			return $param;
		}
		return null;
	}
	
	
	/**
	 * magic method using getParam to retreve a variable from $_POST , $_GET, $_COOKIE, Route
	 * @access public
	 * @param string $var
	 * @return string
	 */
	public function __get($var) {
		return $this->getParam($var);
	}
	
	
	public function __isset($var) {
		return $this->getParam($var) !== null;
	}
}