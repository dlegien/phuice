<?php

	namespace org\legien\phuice\services\database;
		
	use org\legien\phuice\pathing\evaluators\StatementEvaluator;	
	use org\legien\phuice\pathing\Statement;
		
	class PDOService {

		private $_connection;
		private $_evaluator;
		
		public function __construct(StatementEvaluator $evaluator, $type, $database, $host = NULL, $username = NULL, $password = NULL) {
			if($type == 'sqlite') {
				// We are using sqlite
				$dsn = $type.':'.$database;	
			}
			elseif($type == 'mysql') {
				// We are using mysql
				$dsn = $type.':dbname='.$database.';host='.$host;
			}
						
			$this->_connection = new \PDO($dsn, $username, $password);
			$this->_evaluator = $evaluator;
		}
		
		public function prepare(Statement $statement)
		{
			$pdoStatement = $this->_connection->prepare($this->_evaluator->evaluate($statement));
			if($pdoStatement)
			{
				return $pdoStatement;
			}
			$this->catchError($statement);				
		}
		
		public function query(Statement $statement)
		{	
			$pdoStatement = $this->_connection->query($this->_evaluator->evaluate($statement));
			if($pdoStatement)
			{
				return $pdoStatement;
			}
			$this->catchError($statement);
		}
		
		public function catchError(Statement $statement)
		{
			$error = $this->_connection->errorInfo();
			var_dump($error);			
			throw new \Exception('Database error: "' . $error[2]. '" during ' . $this->_evaluator->evaluate($statement));
		}
		
		public function lastInsertId()
		{
			return $this->_connection->lastInsertId();	
		}
		
		public function bindValue($name, $value, $type)
		{
			return $this->_connection->bindValue($name, $value, $type);
		}

		public function getEvaluator() {
			return $this->_evaluator;
		}	
	}
	
