<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	namespace org\legien\phuice\services\database;
		
	use org\legien\phuice\pathing\evaluators\StatementEvaluator;	
	use org\legien\phuice\pathing\Statement;
		
	/**
	 * A PDO wrapper that can handle Statements using a 
	 * StatementEvaluator.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice.services
	 * @subpackage	database
	 *
	 */
	class PDOService 
	{
		/**
		 * The database connection
		 * 
		 * @var \PDO
		 */
		private $_connection;
		
		/**
		 * The evaluator for statements.
		 * 
		 * @var StatementEvaluator
		 */
		private $_evaluator;
		
		/**
		 * Creates a new instance of the wrapper.
		 * 
		 * @param StatementEvaluator 	$evaluator	The evaluator for statements.
		 * @param string 				$type		The connection type (mysql, sqlite).
		 * @param string 				$database	The database name.
		 * @param string 				$host		The hostname.
		 * @param string 				$username	The username.
		 * @param string 				$password	The password.
		 */
		public function __construct(StatementEvaluator $evaluator, $type, $database, $host = NULL, $username = NULL, $password = NULL) 
		{
			if($type == 'sqlite') 
			{
				// We are using sqlite
				$dsn = $type.':'.$database;	
			}
			elseif($type == 'mysql') 
			{
				// We are using mysql
				$dsn = $type.':dbname='.$database.';host='.$host;
			}
						
			$this->_connection = new \PDO($dsn, $username, $password);
			$this->_evaluator = $evaluator;
		}
		
		/**
		 * Prepares the given statement.
		 * 
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		 */
		public function prepare(Statement $statement)
		{
			$pdoStatement = $this->getConnection()->prepare($this->getEvaluator()->evaluate($statement));
			if($pdoStatement)
			{
				return $pdoStatement;
			}
			$this->catchError($statement);				
		}
		
		/**
		 * Performs a query using the given statement.
		 * 
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		 */
		public function query(Statement $statement)
		{	
			$pdoStatement = $this->getConnection()->query($this->getEvaluator()->evaluate($statement));
			if($pdoStatement)
			{
				return $pdoStatement;
			}
			$this->catchError($statement);
		}
		
		/**
		 * Catches a database error and throws an exception.
		 * 
		 * @param Statement $statement	The statement.
		 * @throws PDOException	If a database error occurs
		 */
		public function catchError(Statement $statement)
		{
			$error = $this->getConnection()->errorInfo();			
			throw new PDOException('Database error: "' . $error[2]. '" during ' . $this->getEvaluator()->evaluate($statement));
		}
		
		/**
		 * Returns the last inserted id.
		 * 
		 * @return string
		 */
		public function lastInsertId()
		{
			return $this->getConnection()->lastInsertId();	
		}
		
		/**
		 * Binds a value to a given name and type.
		 * 
		 * @param string 	$name		The name.
		 * @param string 	$value		The value.
		 * @param string 	$type		The type.
		 */
		public function bindValue($name, $value, $type)
		{
			return $this->getConnection()->bindValue($name, $value, $type);
		}

		/**
		 * Returns the used evaluator.
		 * @return StatementEvaluator
		 */
		public function getEvaluator() 
		{
			return $this->_evaluator;
		}
		
		/**
		 * Returns the PDO connection.
		 * 
		 * @return \PDO
		 */
		private function getConnection()
		{
			return $this->_connection;
		}
	}
	
