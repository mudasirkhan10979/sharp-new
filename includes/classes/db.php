<?php 
class myDB {
	private $connection = null;
	private $statement = null;

	public function __construct($hostname, $username, $password, $database, $port = '3306') {
		try {
			$this->connection = new PDO("mysql:host=" . $hostname . ";port=" . $port . ";dbname=" . $database, $username, $password, array(\PDO::ATTR_PERSISTENT => true));
		} catch(PDOException $e) {
			throw new Exception('Failed to connect to database. Reason: \'' . $e->getMessage() . '\'');
		}
		$this->connection->exec("SET NAMES 'utf8'");
		$this->connection->exec("SET CHARACTER SET utf8");
		$this->connection->exec("SET CHARACTER_SET_CONNECTION=utf8");
		$this->connection->exec("SET SQL_MODE = ''");
	}

	public function prepare($sql) {
		$this->statement = $this->connection->prepare($sql);
	}

	public function bindParam($parameter, $variable, $data_type = \PDO::PARAM_STR, $length = 0) {
		if ($length) {
			$this->statement->bindParam($parameter, $variable, $data_type, $length);
		} else {
			$this->statement->bindParam($parameter, $variable, $data_type);
		}
	}

	public function execute() {
		try {
			if ($this->statement && $this->statement->execute()) {
				$data = array();
				while ($row = $this->statement->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
				$result = new stdClass();
				$result->row = (isset($data[0])) ? $data[0] : array();
				$result->rows = $data;
				$result->num_rows = $this->statement->rowCount();
			}
		} catch(PDOException $e) {
			throw new Exception('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode());
		}
	}

	public function query($sql, $params = array()) {
		$this->statement = $this->connection->prepare($sql); 
		$result = false; 
		try {
			if ($this->statement && $this->statement->execute($params)) {
				$data = array();
				while ($row = $this->statement->fetch(PDO::FETCH_ASSOC)) {
					$data[] = $row;
				}
				$result = new stdClass();
				$result->row = (isset($data[0]) ? $data[0] : array());
				$result->rows = $data;
				$result->num_rows = $this->statement->rowCount();
			}
		} catch (PDOException $e) {
			throw new Exception('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
		} 
		if ($result) {
			return $result;
		} else {
			$result = new stdClass();
			$result->row = array();
			$result->rows = array();
			$result->num_rows = 0;
			return $result;
		}
	}

	public function escape($value) {
		return str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), $value);
	}

	public function countAffected() {
		if ($this->statement) {
			return $this->statement->rowCount();
		} else {
			return 0;
		}
	}

	public function getLastId() {
		return $this->connection->lastInsertId();
	}
	
	public function isConnected() {
		if ($this->connection) {
			return true;
		} else {
			return false;
		}
	}
	
	public function __destruct() {
		$this->connection = null;
	}
	public function select($retField, $table, $where="", $groupby="", $orderby="", $limit="",$type="") {
		
		$fields = implode(",", $retField); 
		
		if ($where!="") {
			 $sql_query = "select ". $fields." from ".$table." WHERE ".$where;
		} else {
			 $sql_query = "select ". $fields." from ".$table;
		}

		if ($groupby!="") {
			$sql_query .= " GROUP BY ". $groupby;
		}
		if ($orderby!="") {
			$sql_query .= " ORDER BY ". $orderby;
		}
		if ($limit!="") {
			$sql_query .= " LIMIT ".$limit;
		} 
		
		if($type == 'count'){
			$this->query($sql_query);
			$query = $this->countAffected();
		}
		else{
			$query = $this->query($sql_query);
		}
			 
		return $query;
		
	} 
	
	public function Insert($data,$table) { 
		$fields = array();
		$values = array();
		foreach($data as $key=>$value) { 
			if($key!="submit") {
				$fields[] = $key;
				$values[] = "'".$this->escape($value)."'";
			}
		}
		$sql_fields = implode(",",$fields);
		$sql_value = implode(",",$values);
		$query = $this->connection->exec("INSERT INTO ".$table."(".$sql_fields.") VALUES(".$sql_value.")");
		$lid = $this->getLastId(); 
		return $lid;
	}
	public function Update($data,$table,$where) { 
		$fields_values = array(); 
		foreach($data as $key=>$value) { 
			if($key!="submit") {
				$fields_values[] = $key."='".$this->escape($value)."'"; 
			}
		}
		$fields_values = implode(",",$fields_values);
		$query = $this->connection->exec("UPDATE ".$table." SET ".$fields_values." WHERE ".$where); 
		return $query;
	} 
	public function delete($table="", $condition="") { 
		$query = "DELETE FROM $table WHERE $condition";
		if (!($this->connection->exec($query))) {
			return false;
		} else { 
			return true;
		}
	 } 
	
}