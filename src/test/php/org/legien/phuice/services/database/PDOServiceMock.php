<?php

	namespace org\legien\phuice\services\database;
	
	class PDOServiceMock implements IPDOService
	{
		public function __construct()
		{
			
		}
		
		/**
		 * Prepares the given statement.
		 *
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		 */
		public function prepare(Statement $statement)
		{
			var_dump('prepare');
			var_dump($statement);
		}
		
		/**
		 * Performs a query using the given statement.
		 *
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		*/
		public function query(Statement $statement)
		{
			var_dump('query');
			var_dump($statement);
		}
		
		/**
		 * Catches a database error and throws an exception.
		 *
		 * @param Statement $statement	The statement.
		 * @throws PDOException	If a database error occurs
		*/
		public function catchError(Statement $statement)
		{
			var_dump('catchError');
			var_dump($statement);
		}
		
		/**
		 * Returns the last inserted id.
		 *
		 * @return string
		*/
		public function lastInsertId()
		{
			var_dump('lastInsertId');
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
			var_dump('bindValue');
			var_dump($name);
			var_dump($value);
			var_dump($type);
		}
		
		/**
		 * Returns the used evaluator.
		 * @return StatementEvaluator
		*/
		public function getEvaluator()
		{
			var_dump('getEvaluator');
		}		
	}