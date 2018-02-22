<?php

namespace App\libs;

class Database
{
	/**
     * @var PDO
     */
	protected $_db=null;
	/**
     * @var PDO\Instance
     */
	private static $_instance=null;
	/**
     * Initialize Database
     *
     * @return object 	PDO
     */
	public function __construct(){
		$this->_db = new \PDO("mysql:host=localhost;dbname=donation","root","");
	}
	/**
     * Get Database Instance
     *
     * @return object 	PDO
     */
	public static function getDBInstance(){
		if (!isset(self::$_instance)) {
				
			self::$_instance = new Database();
			return self::$_instance->_db;
		}

		return self::$_instance->_db;
	}
}