<?php
/**
 * Router
 *
 *
 * @package    system
 * @author     Luka Bozhich <luka@bozhich.com>
 */
namespace system;

class Router extends Singleton {
	
	/**
	* @access protected
	* @var Lang
	*/
	protected $lang;
	
	/**
	 * @access protected
	 * @var Controller
	 */
	protected $controller;
	
	/**
	 * @access protected
	 * @var Method
	 */
	protected $method;
	
	/**
	 * @access protected
	 * @var Id
	 */
	protected $id;
	
	/**
	 * @access protected
	 * @var Args
	 */
	protected $args = array();

	
	/**
	 * @access public
	 * @return void
	 */
	public function __construct() { 
		if ($_SERVER['REQUEST_URI'] === '/') {
			$this->defaultRoute();
		} else {
			$this->pathRoute($_SERVER['REQUEST_URI']);
		}
	}
	
	
	/**
	 * @access private
	 * @return void
	 */
	private function defaultRoute() {
		$this->lang 	  = Config::$application['default_route']['lang'];
		$this->controller = Config::$application['default_route']['controller'];
		$this->method     = Config::$application['default_route']['method'];
		$this->id     	  = Config::$application['default_route']['id'];
	}

	
	/**
	 * @access private
	 * @param string $uri
	 * @return void
	 */
	private function pathRoute($uri = '') {
		
		// Explode the url
		$parts = explode('/', trim($uri, '/'));
		
		// language 
		$this->lang = array_shift($parts);

		// controller
		$this->controller = isset($parts[0]) ? array_shift($parts) : Config::$application['default_route']['controller'];
		$this->method = isset($parts[0]) ? array_shift($parts) : Config::$application['default_route']['method'];
		$this->id = isset($parts[0]) ? array_shift($parts) : Config::$application['default_route']['id'];
		
		// Set the args to the rest of the url parts
		$this->args = $parts;
	}

	
	/**
	 * Runs the application
	 * @access public
	 * @return string
	 */
	public function fire() {
		$controller = 'app\\Controllers\\' . ucfirst($this->controller);
		if(class_exists($controller)) {
			$controller = new $controller;
		} else {
			$controller = new \app\Controllers\Error;
			return $controller->index();
		}

		if (!$controller->restful) {
			// prepended with 'action_'
			$method = "action_".$this->method;
		} else {
			// Restful is set to true so preppend the request name
			// ( POST, GET, PUT, DELETE, HEAD ) to the method
			$method = strtolower($_SERVER['REQUEST_METHOD'])."_" .$this->method;
		}

		if (method_exists($controller, $method)) {
			// Call the method giving the args array
			return call_user_func_array(array($controller, $method), $this->args);
		} else {
			// Method doesn't exist
			$controller = new \app\Controllers\Error;
			
			// Call the index method
			return $controller->index();
		}
	}

	
	/**
	 * gets all the current routes
	 * @access public
	 * @return array
	 */	
	public function getRoutes() {
		return array(
				'lang' => $this->lang,
				'controller' => $this->controller,
				'method' => $this->method,
				'id' => $this->id,
				'args' => $this->args,
		);
	}
	
	
	/**
	 * gets a specific route
	 * @access public
	 * @param string $route
	 * @return array
	 */
	public function getRoute($route) {
		return $this->{$route};
	}
}