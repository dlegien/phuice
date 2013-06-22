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
	 * Interface for PDOServices. Mainly used for unit testing as this allows to
	 * mock away the database connection.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.services
	 * @subpackage	database
	 *
	 */
	interface IPDOService
	{		
		/**
		 * Prepares the given statement.
		 *
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		 */
		public function prepare(Statement $statement);
		
		/**
		 * Performs a query using the given statement.
		 *
		 * @param Statement $statement	The statement.
		 * @return PDOStatement
		 */
		public function query(Statement $statement);
		
		/**
		 * Catches a database error and throws an exception.
		 *
		 * @param Statement $statement	The statement.
		 * @throws PDOException	If a database error occurs
		 */
		public function catchError(Statement $statement, \PDOStatement $pdoStatement);
		
		/**
		 * Returns the last inserted id.
		 *
		 * @return string
		 */
		public function lastInsertId();
		
		/**
		 * Binds a value to a given name and type.
		 *
		 * @param string 	$name		The name.
		 * @param string 	$value		The value.
		 * @param string 	$type		The type.
		 */
		public function bindValue($name, $value, $type);
		
		/**
		 * Returns the used evaluator.
		 * @return StatementEvaluator
		 */
		public function getEvaluator();
	}