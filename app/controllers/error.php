<?php
namespace app\Controllers;

use system\mvc\Controller;

class Error extends Controller {

	public function index() {
		echo '<pre>';
		debug_print_backtrace();
	}

}