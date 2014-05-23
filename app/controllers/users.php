<?php
namespace app\Controllers;
use system\mvc\Controller;

class Users extends Controller {

	public $restful = false;

	public function action_index() {
		$this->getView()->setMainFile('users.login');
	}
}
