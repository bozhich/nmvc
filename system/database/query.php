<?php 
/**
 * Query
 *
 *
 * @package		system
 * @subpackage	database
 * @author		Luka Bozhich <luka@bozhich.com>
 */
namespace system\Database;

class Query {
	
	/**
	 * @access private
	 * @var Table
	 */
	private $table;
	
	/**
	 * @access private
	 * @var array
	 */
	private $where = array();
	
	/**
	 * @access private
	 * @var limit
	 */
	private $limit;
	
	/**
	 * @access private
	 * @var array
	 */
	private $bindings = array();


	/**
	 * @access public
	 * @param string $route
	 * @return void
	 */
	public function __construct($table) {
		$this->table = $table;
	}

	
	/**
	 * @access public
	 * @param string $key
	 * @param string $oper
	 * @param string $value
	 * @return void
	 */
	public function where($key, $oper, $value) {
		$this->where[]	= "AND ".$key.' '.$oper.' '."?";
		$this->bindings[] = $value;
	}
	
	
	/**
	 * @access public
	 * @param string $key
	 * @param string $oper
	 * @param string $value
	 * @return void
	 */
	public function orWhere($key, $oper, $value) {
		$this->where[]	= "OR " . $key . ' ' . $oper . ' ' . "?";
		$this->bindings[] = $value;
	}

	
	/**
	 * @access public
	 * @param int $limit
	 * @return void
	 */
	public function limit($limit = 10) {
		$this->limit = $limit;
	}

	
	/**
	 * @access public
	 * @param string $columns
	 * @param int $fetch_mode
	 * @param string $class_name
	 * @return array
	 */
	public function get($columns = "*", $fetch_mode = \PDO::FETCH_ASSOC, $class_name = '') {
		$sql = "SELECT ".$columns." FROM ".$this->table.
		$this->getWhere().
		$this->getLimit();

		$sth = db::prepare($sql);
		
		if ($fetch_mode == \PDO::FETCH_CLASS) {
			$sth->setFetchMode( $fetch_mode, $class_name );
		} else {
			$sth->setFetchMode( $fetch_mode );
		}
		
		for($i = 1; $i <= count($this->bindings); $i ++) {
			$sth->bindParam($i, $this->bindings[$i - 1] );
		}

		$sth->execute();

		return $sth->fetchAll();
	}

	
	//( ! ) Strict standards: Only variables should be passed by reference in 
	// /home/luka/www/luka/system/database/query.php on line 53
	/**
	 * @access public
	 * @param string $columns
	 * @param int $fetch_mode
	 * @param string $class_name
	 * @return array
	 */
	public function first($columns = '*', $fetch_mode = \PDO::FETCH_ASSOC, $class_name = '') {
		return array_shift(
				$this->get($columns, $fetch_mode, $class_name)
			);
	}

	
	/**
	 * By default if there is ID in the $attributes, there will be update 
	 * @access public
	 * @param array $attributes
	 * @param string $id_name
	 * @return void
	 */
	public function save($attributes = array(), $id_name = "id" ) {
		$attributes = $this->matchColumns($attributes);
		if(isset($attributes[$id_name])) {
			$sql = $this->getUpdate($attributes, $id_name);
		} else {
			$sql = $this->getInsert($attributes);
		}
		
		$sth = DB::prepare( $sql );
		$sth->execute( $attributes );
	}

	
	/**
	 * @access private
	 * @param array $attributes
	 * @return void
	 */
	private function getInsert($attributes = array()) 	{
		$keys = array_keys($attributes);
		return "INSERT INTO ". $this->table .
			"(". implode("," , $keys  ) .")".
			" VALUES(:". implode(",:", $keys  ) .")";
	}

	
	/**
	 * @access private
	 * @param array $attributes
	 * @param string $id_name
	 * @return string
	 */
	private function getUpdate($attributes, $id_name) {
		$updates = '';
		foreach ($attributes as $key => $value) {
			$updates .= $key.'=:'.$key.',';
		}
		$updates = rtrim($updates, ",");
		
		return "UPDATE ". $this->table .
				" SET ".$updates.
			" WHERE ".$id_name."=:".$id_name;
	}
	
	
	/**
	 * @access private
	 * @return string
	 */
	private function getWhere() {
		if(empty($this->where)) {
			return '';
		}
		$where_sql = ' WHERE '.ltrim(implode(" ", $this->where), "ANDOR");
		return $where_sql;
	}
	
	
	/**
	 * @access private
	 * @return string | void
	 */
	private function getLimit() {
		if(isset($limit)) {
			return " Limit ".$limit;
		}
	}

	
	/**
	 * @access private
	 * @param array $attributes
	 * @return array
	 */
	private function matchColumns($attributes) {
		$new = array();
		$statement = DB::query('DESCRIBE ' . $this->table);

		foreach($statement->fetchAll(\PDO::FETCH_ASSOC ) as $row) {
			if(isset( $attributes[ $row['Field'] ] )) {
				$new[ $row['Field'] ] = $attributes[ $row['Field'] ];
			}
		}
		return $new;
	}
	
}
