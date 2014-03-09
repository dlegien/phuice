<?php

	namespace org\legien\phuice\storages;
	
	use org\legien\phuice\pathing\Statement;
	
	/**
	 * An abstract storage for persisting models to the database.
	 * 
	 * @author Daniel Legien
	 */
	interface IAbstractStorage
	{	
		/**
		 * Deletes the given object from the database.
		 *
		 * @param Model	$obj	The object to delete
		 *
		 * @throws \Exception	If there was a database problem
		 *
		 * @return boolean
		 */
		public function delete($obj);
		
		/**
		 * Persitates the model to the database and returns the last
		 * inserted id.
		 *
		 * @param Model $obj The object to save.
		 *
		 * @throws \Exception If there was a database problem.
		 *
		 * @return string
		 */
		public function create($obj, $nesting = TRUE);
		
		/**
		 * Updates the given model in the database.
		 *
		 * @param Model $obj The object to update.
		 *
		 * @throws \Exception If there was a database problem.
		 *
		 * @return boolean
		 */
		public function update($obj);
		
		/**
		 * An alias for a search that returns a set.
		 *
		 * @param array $filters The filters to apply.
		 * @param array $orderBy The orderings to apply.
		 * @param array $limit The offset and max result for the query.
		 */
		public function findAll(array $filters = array(), array $orderBy = array(), $limit = false);
				
		/**
		 * Performs a search using the given statement. This allows for
		 * additional flexibility.
		 *
		 * @param Statement $stmt The statement.
		 *
		 * @throws \Exception If there was a database problem.
		 * @return array
		 */
		public function findCustom(Statement $stmt);
		
		/**
		 * Returns a new transaction.
		 *
		 * @return \org\legien\phuice\services\database\ITransaction
		 */
		public function createTransaction();
	}