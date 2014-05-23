<?php
namespace app\Controllers;
use system\mvc\Controller,
	system\mvc\View, 
	app\Models\User as Model;

class Index extends Controller {

	public $restful = false;

	public function get_index() {
	}

	public function post_index() {
	}

	public function action_index() {
		$this->getView()->asd = 'luka';
	}
}
