<?php

return array(
	
	/**
	 *  development, testing and production
	 */
	'environment' => 'development',

	/**
	 * Without trailing slashes
	 */
	'base_url' => '*****',

	/**
	 * Default Routes
	 */
	'default_route' => array('lang'		  => 'en_EN',
							 'controller' => 'index',
					   		 'method'     => 'index',
							 'id'		  => 0),
		
	/**
	 * Static Adress where the css / js / img are located
	 */
	'static_address' => '*base_url*/static'
);