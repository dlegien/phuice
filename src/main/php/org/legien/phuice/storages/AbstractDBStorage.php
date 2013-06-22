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

	namespace org\legien\phuice\storages;

	use org\legien\phuice\services\database\IPDOService;
	use org\legien\phuice\pathing\Statement;
	use org\legien\phuice\pathing\Condition;
	use org\legien\phuice\pathing\AndConditionGroup;

	/**
	 * An abstract storage that reduces the necessary implementations in
	 * the specific storages. 
	 * 
	 * @deprecated Use org\legien\phuice\repositories\AbstractRepository
	 * instead.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	abstract class AbstractDBStorage 
	{
		/**
		 * A cache for objects.
		 * 
		 * @var array
		 */
		private $_cache = array();
		
		/**
		 * The database connection.
		 * 
		 * @var PDOService
		 */
		private $_connection;
		
		/**
		 * The table holding the entities.
		 * 
		 * @var string
		 */
		private $_table;
		
		/**
		 * The name of the model class.
		 * 
		 * @var string
		 */
		private $_modelname;
		
		/**
		 * Whether the storage is an aggregate storage.
		 * 
		 * @var boolean
		 */
		private $_isAggregateStorage;
		
		/**
		 * Initializes the storage.
		 * 
		 * @param PDOService	$connection	The database connection.
		 * @param string		$table		The table holding the entities.
		 * @param string		$model		The name of the model class.
		 */
		public function __construct(IPDOService $connection, $table, $model) 
		{
			$this->setConnection($connection);
			$this->setTable($table);
			$this->setModel($model);
			$this->setIsAggregate(FALSE);
		}

		/**
		 * Sets the table holding the entites.
		 * 
		 * @param string $table The table.
		 */
		private function setTable($table) 
		{
			$this->_table = $table;
		}

		/**
		 * Sets the name of the model class.
		 * 
		 * @param string $model The model class name.
		 */
		private function setModel($model) 
		{
			$this->_modelname = $model;
		}

		/**
		 * Sets the database connection.
		 * 
		 * @param PDOService $connection The database connection.
		 */
		private function setConnection(IPDOService $connection) 
		{
			$this->_connection = $connection;
		}
		
		/**
		 * Writes an object to the object cache.
		 * 
		 * @param object $obj The object to cache.
		 */
		protected function cacheObject(&$obj) 
		{
			if($obj !== FALSE) 
			{
				$oldObj = unserialize(serialize($obj));
				$hash = spl_object_hash($oldObj);
				
				$this->_cache[$hash] = $oldObj;
				$obj->objhashentry = $hash;
			}
		}
		
		/**
		 * Returns an array of attributes of the model.
		 * 
		 * @param Model $obj The model.
		 * 
		 * @return array
		 */
		protected function getKeys($obj) 
		{
			return array_keys($obj->toArray());
		}

		/**
		 * Generates the binding for the database interaction by
		 * retrieving the attributes from the model.
		 * 
		 * @param Model		$obj	The model.
		 * @param string 	$prefix	The prefix to use.
		 * 
		 * @return array
		 */
		protected function generateBind($obj, $prefix = NULL, $remove = array()) 
		{
			$bind = array();
			
			foreach($obj->toArray() as $key => $value)
			{
				if(!in_array($key, $remove))
				{
					if(!is_null($prefix))
					{
						$key = "o$key";
					}
					$bind[':'.$key] = $value;
				}
			}			
			return $bind;
		}
		
		/**
		 * Deletes the given object from the database.
		 * 
		 * @param Model	$obj	The object to delete
		 * 
		 * @throws \Exception	If there was a database problem
		 * 
		 * @return boolean
		 */
		public function delete($obj)
		{
			$objKeys = $this->getKeys($obj);
			
			$stmt = new Statement;
			$stmt->deleteFrom($this->_table);
			
			if($this->isAggregate())
			{
				$this->addAggregates($stmt);
				$stmt->select($this->_table);
				foreach($this->getMappings() as $mapping)
				{
					$stmt->select($mapping->getSourceTable());
				}
				
				$ind = array_keys($objKeys, 'id'); 
				unset($objKeys[$ind[0]]);
				$objKeys[] = $this->_table.'.id';
			}

			$grp = new AndConditionGroup;

			foreach($objKeys as $objKey)
			{
				$grp->set(new Condition($objKey, '=', ':'.str_replace('.', '', $objKey), FALSE));
			}

			if(count($objKeys) > 0) {
				$stmt->where($grp);
			}
			
			if(!$statement = $this->_connection->prepare($stmt))
			{
				throw new \Exception('Couldn\'t prepare statement in AbstractDBStorage.delete');
			}
			
			$binds = $this->generateBind($obj);
			
			if($this->isAggregate())
			{
				unset($binds[':id']);
				$index = ':'.$this->_table.'id';
				$binds[$index] = $this->getProtectedValue($obj, 'id');
			}
			
			if(!$statement->execute($binds))
			{
				$this->_connection->catchError($stmt, $statement);
				throw new \Exception('Couldn\'t execute statement in AbstractDBStorage.delete with ' . implode(', ',$this->generateBind($obj)));
			}
			return TRUE;
		}
		
		/**
		 * Copies the given field's value from one object to another.
		 * 
		 * @param object $from	The source object.
		 * @param object $to	The destination object.
		 * @param string $key	The name of the field.
		 */
		private function copyProtectedValue(&$from, &$to, $key)
		{
			$fromObject = new \ReflectionObject($from);
			$toObject = new \ReflectionObject($to);
			
			$toProperty = $toObject->getProperty($key);
			$toProperty->setAccessible(TRUE);
			
			$fromProperty = $fromObject->getProperty($key);
			$fromProperty->setAccessible(TRUE);
						
			$toProperty->setValue($to, $fromProperty->getValue($from));
		}
		
		/**
		 * Sets the value of the given property to the given value.
		 * 
		 * @param object	$to		The destination object.
		 * @param string	$key	The name of the property.
		 * @param mixed		$value	The value to set.
		 */
		private function setProtectedValue(&$to, $key, $value)
		{
			$toObject = new \ReflectionObject($to);
				
			$toProperty = $toObject->getProperty($key);
			$toProperty->setAccessible(TRUE);

			$toProperty->setValue($to, $value);
		}
		
		/**
		 * Returns the value of the given property.
		 * 
		 * @param object $from	The destination object.
		 * @param string $key	The name of the property.
		 * 
		 * @return mixed
		 */
		private function getProtectedValue($from, $key)
		{
			$fromObject = new \ReflectionObject($from);				
			$fromProperty = $fromObject->getProperty($key);
			$fromProperty->setAccessible(TRUE);			
			return $fromProperty->getValue($from);			
		}
		
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
		public function create($obj, $nesting = TRUE)
		{
			$objKeys = $this->getKeys($obj);

			$remove = array();
			
			if($this->isAggregate() && $nesting)
			{	
				$mappings = $this->getMappings();
				
				foreach($mappings as $mapping)
				{
					$model = $mapping->getSourceModel();

					$op = new $model;
					$opKeys = $this->getKeys($op);	
					
					foreach(array_intersect($objKeys, $opKeys) as $key)
					{
						if($key != 'id')
						{
							$index = array_keys($objKeys, $key);
							unset($objKeys[$index[0]]);
							$remove[] = $key;
						}
						
						$this->copyProtectedValue($obj, $op, $key);
					}

					$tmp = $this->_table;
					$this->_table = $mapping->getSourceTable();
					$cid = $this->create($op, FALSE);
					$this->_table = $tmp;
					
					$this->setProtectedValue($obj, 'id', $cid);
				}
			}
			
			$stmt = new Statement;
			$stmt
				->insertInto($this->_table)
			;	
			
			foreach($objKeys as $objKey)
			{
				$stmt->field($objKey);
				$stmt->value(':'.$objKey, FALSE);
			}
															
			if(!$statement = $this->_connection->prepare($stmt))
			{
				throw new \Exception('Couldn\'t prepare statement in AbstractDBStorage.create');
			}
						
			if(!$statement->execute($this->generateBind($obj, NULL, $remove)))
			{
				$this->_connection->catchError($stmt, $statement);
				throw new \Exception('AbstractDBStorage.create: Couldn\'t execute statement '.$stmt.' with ' . implode(', ',$this->generateBind($obj)));
			}
			
			return $this->_connection->lastInsertId();
		}
		
		/**
		 * Updates the given model in the database.
		 * 
		 * @param Model $obj The object to update.
		 * 
		 * @throws \Exception If there was a database problem.
		 * 
		 * @return boolean
		 */
		public function update($obj) 
		{
			if(isset($this->_cache[$obj->objhashentry]) && $obj instanceof $this->_cache[$obj->objhashentry]) 
			{
				$oldObj = $this->_cache[$obj->objhashentry];
				
				$newObjKeys = $this->getKeys($obj);
				$oldObjKeys = $this->getKeys($oldObj);
				
				$stmt = new Statement;
				
				$stmt
					->update($this->_table);
				
				if($this->isAggregate())
				{
					$this->addAggregates($stmt);
					
					$oindex = array_keys($oldObjKeys, 'id');
					unset($oldObjKeys[$oindex[0]]);
					$oldObjKeys[] = $this->_table.'.id';
					
					$nindex = array_keys($newObjKeys, 'id');
					unset($newObjKeys[$nindex[0]]);
					$newObjKeys[] = $this->_table.'.id';
				}
					
				foreach($newObjKeys as $newObjKey)
				{
					$stmt->set($newObjKey, ':'.str_replace('.', '', $newObjKey), FALSE);	
				}
				
				$grp = new AndConditionGroup;
				foreach($oldObjKeys as $oldObjKey)
				{
					$grp->set(new Condition($oldObjKey, '=', ':o'.str_replace('.', '', $oldObjKey), FALSE));					
				}
				$stmt->where($grp);
				
				if(!$statement = $this->_connection->prepare($stmt))
				{
					throw new \Exception('Couldn\'t prepare statement in AbstractDBStorage.update');
				}
				
				$binds = array_merge($this->generateBind($obj),$this->generateBind($oldObj, 'o'));
						
				if($this->isAggregate())
				{
					unset($binds[':oid']);
					unset($binds[':id']);
					
					$oindex = ':o'.$this->_table.'id';
					$binds[$oindex] = $this->getProtectedValue($oldObj, 'id');
					$nindex = ':'.$this->_table.'id';
					$binds[$nindex] = $this->getProtectedValue($obj, 'id');
				}
				
				var_dump($binds);
				
				if(!$statement->execute($binds))
				{
					$this->_connection->catchError($stmt, $statement);
				}
				
				return TRUE;				
			}
			return FALSE;
		}
		
		/**
		 * Processes the filters and adds them to the statement and binding.
		 * 
		 * @param array		$bind		The bindings.
		 * @param Statement	$stmt		The statement.
		 * @param array		$filters	The filters.
		 */
		private function processFilters(&$bind, &$stmt, $filters)
		{		
			$grp = new AndConditionGroup;
					
			foreach($filters as $filter)
			{
				if($filter instanceof StorageFilter)
				{
					$grp->set(new Condition($this->_table.'.'.$filter->getField(), $filter->getRelation(), ':'.$filter->getField(), FALSE));
					$bind[':'.$filter->getField()] = $filter->getValue();
				}
			}

			if(count($filters) > 0)
			{
				$stmt->where($grp);
			}			
		}
		
		/**
		 * Processes the orderings and adds them to the statement.
		 * 
		 * @param Statement	$stmt		The statement.
		 * @param array		$orderBy	The orderings.
		 */
		private function processOrderings(&$stmt, $orderBy)
		{
			foreach($orderBy as $order)
			{
				if($order instanceof StorageOrdering)
				{
					$stmt->orderby($order->getField(), $order->getDirection());
				}
			}
		}
		
		/**
		 * Creates the query statement.
		 * 
		 * @return Statement
		 */
		private function createFindStatement()
		{
			$stmt = new Statement;
			$stmt
				->select('*')
				->from($this->_table)
			;
			
			if($this->isAggregate())
			{
				$this->addAggregates($stmt);
			}
			
			return $stmt;
		}
		
		/**
		 * Adds aggregate information to the statement.
		 * 
		 * @param Statement $stmt The statement to alter.
		 */
		private function addAggregates(Statement $stmt)
		{
			foreach($this->getMappings() as $mapping)
			{	
				foreach($mapping->getKeyRelations() as $relation)
				{
					$joins[] = $mapping->getSourceTable().'.'.$relation->getSourceKey().$relation->getRelation().$this->_table.'.'.$relation->getDestinationKey();
				} 
				
				$join = implode(' AND ', $joins);				
				$stmt->join($mapping->getSourceTable(), $join, Statement::$LEFT_JOIN);
			}
		}
		
		/**
		 * Performs a search for entities.
		 * 
		 * @param array		$filters	The filters to apply.
		 * @param array		$orderBy	The orderings to apply.
		 * @param boolean	$set		Whether the result should be a list of entities.
		 * 
		 * @return mixed
		 */
		protected function find(array $filters = array(), array $orderBy = array(), $set = FALSE)
		{
			$bind = array();
			$stmt = $this->createFindStatement();						
			$this->processFilters($bind, $stmt, $filters);
			$this->processOrderings($stmt, $orderBy);
						
			return $this->performStatement($bind, $stmt, $set);
		}

		/**
		 * Performs the actual search process.
		 * 
		 * @param array		$bind	The bindings.
		 * @param Statment	$stmt	The statement.
		 * @param boolean	$set	Whether to return a set.
		 * 
		 * @throws \Exception If there was a database problem.
		 * @return mixed
		 */
		private function performStatement($bind, $stmt, $set) 
		{
			if(!$statement = $this->_connection->prepare($stmt))
			{
				throw new \Exception('Couldn\'t prepare statement.');
			}

			if(count($bind) > 0) 
			{
				if(!$statement->execute($bind)) 
				{
					try 
					{
						$this->_connection->catchError($stmt, $statement);
					}
					catch(\Exception $e) 
					{
						throw new \Exception('AbstractDBStorage.create: ' . $e->getMessage() . '. Couldn\'t execute statement '.$stmt.' with ' . implode(', ',$bind));
					}					
				}
			}
			else 
			{
				if(!$statement->execute())
				{
					try
					{
						$this->_connection->catchError($stmt, $statement);
					}
					catch(\Exception $e)
					{
						throw new \Exception('AbstractDBStorage.create: ' . $e->getMessage() . '. Couldn\'t execute statement '.$stmt);	
					}				
				}	
			}
			
			if($set)
			{
				$objects = $statement->fetchAll(\PDO::FETCH_CLASS, $this->_modelname);
				foreach($objects as $newobject)
				{
					$this->cacheObject($newobject);
				}
				
				return $objects;
			}
			else
			{
				$newobject = $statement->fetchObject($this->_modelname);
				
				$this->cacheObject($newobject);
				return $newobject;
			}
		}

		/**
		 * An alias for a search that returns a set.
		 * 
		 * @param array $filters The filters to apply.
		 * @param array $orderBy The orderings to apply.
		 */
		public function findAll(array $filters = array(), array $orderBy = array())
		{
			return $this->find($filters, $orderBy, TRUE);
		}

		/**
		 * Performs a search using the given statement. This allows for
		 * additional flexibility.
		 * 
		 * @param Statement $stmt The statement.
		 * 
		 * @throws \Exception If there was a database problem.
		 * @return array
		 */
		public function findCustom(Statement $stmt)
		{							
			if(!$statement = $this->_connection->prepare($stmt))
			{
				throw new \Exception('AbstractDBStorage.findCustom(): Couldn\'t prepare statement');
			}
						
			if(!$statement->execute())
			{
				try
				{
					$this->_connection->catchError($stmt, $statement);
				}
				catch(\Exception $e)
				{
					throw new \Exception('AbstractDBStorage.create: ' . $e->getMessage() . '. Couldn\'t execute statement '.$stmt);	
				}				
			}

			return $statement->fetchAll(\PDO::FETCH_CLASS, $this->_modelname);
		}
		
		/**
		 * Sets whether the storage is an aggregate storage.
		 * 
		 * @param boolean $isAggregate Whether the storage is an aggregate storage.
		 */
		protected function setIsAggregate($isAggregate)
		{
			$this->_isAggregateStorage = $isAggregate;
		}
		
		/**
		 * Returns whether the storage is an aggregate storage.
		 * 
		 * @return boolean
		 */
		private function isAggregate()
		{
			return $this->_isAggregateStorage;
		}
		
		/**
		 * Standard mappings (none).
		 * 
		 * @return array
		 */
		protected function getMappings()
		{
			return array();
		}
	}
