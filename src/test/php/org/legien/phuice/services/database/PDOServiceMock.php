<?php

	namespace org\legien\phuice\services\database;
	
	use org\legien\phuice\pathing\evaluators\StatementEvaluator;
	use org\legien\phuice\pathing\Statement;
	use org\legien\phuice\testing\AbstractMock;
	
	class PDOServiceMock extends AbstractMock implements IPDOService
	{
		private $statement;
		private $calls;
		
		public function __construct($return)
		{
			$this->calls = array();			
			$this->statement = new StatementFake($this, $return);
		}
		
		/**
		 * Prepares the given statement.
		 *
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		 */
		public function prepare(Statement $statement)
		{
			$this->registerCall('PDOServiceMock', 'prepare', array($statement));			
			return $this->statement;
		}
		
		/**
		 * Performs a query using the given statement.
		 *
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		*/
		public function query(Statement $statement)
		{
			$this->registerCall('PDOServiceMock', 'query', array($statement));
		}
		
		/**
		 * Catches a database error and throws an exception.
		 *
		 * @param Statement $statement	The statement.
		 * @throws PDOException	If a database error occurs
		*/
		public function catchError(Statement $statement)
		{
			$this->registerCall('PDOServiceMock', 'catchError', array($statement));
		}
		
		/**
		 * Returns the last inserted id.
		 *
		 * @return string
		*/
		public function lastInsertId()
		{
			$this->registerCall('PDOServiceMock', 'lastInsertId', array());
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
			$this->registerCall('PDOServiceMock', 'bindValue', array($name, $value, $type));
		}
		
		/**
		 * Returns the used evaluator.
		 * @return StatementEvaluator
		*/
		public function getEvaluator()
		{
			$this->registerCall('PDOServiceMock', 'getEvaluator', array());
		}	
	}