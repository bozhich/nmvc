<?php
namespace app\Models;
use system\mvc\Model;

class User extends Model {
	public static $table = "users";

	public static function getUsers() {
		return self::select('*')
					->from(self::$table)
					->fetchAll();
	}

}