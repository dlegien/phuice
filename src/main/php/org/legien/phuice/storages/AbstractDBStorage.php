<?php
	namespace org\legien\phuice\storages;

	use org\legien\phuice\services\database\PDOService;
	use org\legien\phuice\pathing\Statement;
	use org\legien\phuice\pathing\Condition;
	use org\legien\phuice\pathing\AndConditionGroup;

	abstract class AbstractDBStorage {

		private $_cache = array();
		private $_connection;
		private $_table;
		private $_modelname;

		public function __construct(PDOService $connection, $table, $model) {
			$this->setConnection($connection);
			$this->setTable($table);
			$this->setModel($model);
		}

		private function setTable($table) {
			$this->_table = $table;
		}

		private function setModel($model) {
			$this->_modelname = $model;
		}

		private function setConnection(PDOService $connection) {
			$this->_connection = $connection;
		}
		
		protected function cacheObject(&$obj) {
			if($obj !== FALSE) {
				$oldObj = unserialize(serialize($obj));
				$hash = spl_object_hash($oldObj);
				
				$this->_cache[$hash] = $oldObj;
				$obj->objhashentry = $hash;
			}
		}
		
		protected function getKeys($obj) {
			return array_keys($obj->toArray());
		}
				
		protected function generateBind($obj, $prefix = NULL) {
			$bind = array();
			
			foreach($obj->toArray() as $key => $value)
			{
				if(!is_null($prefix))
				{
					$key = "o$key";
				}
				$bind[':'.$key] = $value;
			}			
			return $bind;
		}
		
		public function delete($obj)
		{
			$objKeys = $this->getKeys($obj);
			
			$stmt = new Statement;
			$stmt->deleteFrom($this->_table);

			$grp = new AndConditionGroup;

			foreach($objKeys as $objKey)
			{
				$grp->set(new Condition($objKey, '=', ':'.$objKey, FALSE));
			}

			if(count($objKeys) > 0) {
				$stmt->where($grp);
			}
			
			if(!$statement = $this->_connection->prepare($stmt))
			{
				throw new \Exception('Couldn\'t prepare statement in AbstractDBStorage.delete');
			}
			
			if(!$statement->execute($this->generateBind($obj)))
			{
				throw new \Exception('Couldn\'t execute statement in AbstractDBStorage.delete with ' . implode(', ',$this->generateBind($obj)));
			}
			return TRUE;
		}
		
		public function create($obj)
		{
			$objKeys = $this->getKeys($obj);
				
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
						
			if(!$statement->execute($this->generateBind($obj)))
			{
				$this->_connection->catchError($stmt);
				throw new \Exception('AbstractDBStorage.create: Couldn\'t execute statement '.$stmt.' with ' . implode(', ',$this->generateBind($obj)));
			}
			
			return $this->_connection->lastInsertId();
		}
		
		public function update($obj) {
			if(isset($this->_cache[$obj->objhashentry]) && $obj instanceof $this->_cache[$obj->objhashentry]) {
				$oldObj = $this->_cache[$obj->objhashentry];
				
				$newObjKeys = $this->getKeys($obj);
				$oldObjKeys = $this->getKeys($oldObj);
				
				$stmt = new Statement;
				
				$stmt
					->update($this->_table);
					
				foreach($newObjKeys as $newObjKey)
				{
					$stmt->set($newObjKey, ':'.$newObjKey, FALSE);	
				}
				
				$grp = new AndConditionGroup;
				foreach($oldObjKeys as $oldObjKey)
				{
					$grp->set(new Condition($oldObjKey, '=', ':o'.$oldObjKey, FALSE));					
				}
				$stmt->where($grp);
				
				if(!$statement = $this->_connection->prepare($stmt))
				{
					throw new \Exception('Couldn\'t prepare statement in AbstractDBStorage.update');
				}
				
				$binds = array_merge($this->generateBind($obj),$this->generateBind($oldObj, 'o'));
						
				if(!$statement->execute($binds))
				{
					throw new \Exception('Couldn\'t execute statement in AbstractDBStorage.update with ' . implode(', ',$binds));
				}
				
				return TRUE;				
			}
			return FALSE;
		}
		
		protected function find(array $filters = array(), array $orderBy = array(), $set = FALSE)
		{
			$stmt = new Statement;
			$stmt
				->select('*')
				->from($this->_table)
			;
						
			$bind = array();
			
			if(count($filters) > 0)
			{
				$grp = new AndConditionGroup; 
			
				foreach($filters as $filter)
				{
					if($filter instanceof StorageFilter)
					{
						$grp->set(new Condition($filter->getField(), $filter->getRelation(), ':'.$filter->getField(), FALSE));					
						$bind[':'.$filter->getField()] = $filter->getValue();						
					}
					else
					{
						throw new \Exception('AbstractDBStorage find requires the provided filter list to consist of StorageFilters');
					}					
				}
				$stmt->where($grp);
			}
							
			foreach($orderBy as $order)
			{
				if($order instanceof StorageOrdering)
				{
					$stmt->orderby($order->getField(), $order->getDirection());									
				}
				else
				{
					throw new \Exception('AbstractDBStorage find requires the provided ordering list to consist of StorageOrderings');
				}
			}

			if(!$statement = $this->_connection->prepare($stmt))
			{
				throw new \Exception('Couldn\'t prepare statement.');
			}
						
			if(count($bind) > 0)
			{
				if(!$statement->execute($bind))
				{
					try{
						$this->_connection->catchError($stmt);
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
					try{
						$this->_connection->catchError($stmt);
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

		public function findAll(array $filters = array(), array $orderBy = array())
		{
			return $this->find($filters, $orderBy, TRUE);
		}

		public function findCustom(Statement $stmt)
		{							
			if(!$statement = $this->_connection->prepare($stmt))
			{
				throw new \Exception('AbstractDBStorage.findCustom(): Couldn\'t prepare statement');
			}
						
			$statement->execute();	

			return $statement->fetchAll(\PDO::FETCH_CLASS, $this->_modelname);
		}
	}
