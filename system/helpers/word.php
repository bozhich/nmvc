<?php
/**
 * Word
 *
 *
 * @package		system
 * @subpackage	helper
 * @author		Luka Bozhich <luka@bozhich.com>
 */
namespace system\helpers;

class Word {

	/**
	 * Turns $word to singular
	 * @access public
	 * @param String $word
	 * @return string
	 */
	public static function singular($word) {
		return rtrim($word, "s");
	}

	
	/**
	 * Turns $word to plural
	 * @access public
	 * @param String $word
	 * @return string
	 */
	public static function plural($word) {
		return $word . 's';
	}

}