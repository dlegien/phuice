<?php

	namespace org\legien\phuice\structures;

	use org\legien\phuice\services\database\IPDOService;
	use org\legien\phuice\pathing\Statement;
	use org\legien\phuice\pathing\Condition;
	use org\legien\phuice\pathing\evaluators\SQLStatementEvaluator;
		
	/**
	 * A gateway for retrieving structure information about a 
	 * database table.
	 * 
	 * @author 		Rüdiger Willmann <r.willmann@design-it.de>
	 * @package		org.legien.phuice
	 * @subpackage	structures
	 * 
	 */
	class StructureGateway implements StructureGatewayInterface
	{
		/**
		 * The service used for the connection to the database.
		 *
		 * @var IPDOService
		 */		
		protected $connection;

		/**
		 * Creates a new StructureGateway with the provided service.
		 * 
		 * @param	IPDOService		$connection	The service to use.
		 * 
		 */
		public function __construct(IPDOService $connection)
		{
			$this->connection = $connection;
		}
		
		/**
		 * Returns a list of all tables.
		 * 
		 * @return array
		 */
		public function findTables($pattern = FALSE) 
		{
			$statement = new Statement;
			$statement->showTables($pattern);
			
			return $this->connection->query($statement)->fetchAll(
				\PDO::FETCH_CLASS,
				'org\legien\phuice\structures\Table'
			);
		}

		/**
		 * Get table columns 
		 * 
		 * @param Table $table
		 * @param string $pattern
		 * @return Column
		 */		
		public function findTableColumns(Table $table, $pattern=false) 
		{
			$statement = new Statement;
			$statement->showTableColumns($table->getName());
			if ($pattern !== false) 
			{
				$statement->where(new Condition('Field', 'like', $pattern));
			}

			return $this->connection->query($statement)->fetchAll(
				\PDO::FETCH_CLASS,
				'org\legien\phuice\structures\Column'
			);
		}
		
		/**
		 * Returns the indexes of the given table.
		 * 
		 * @param Table $table The table.
		 * 
		 * @return [Index]
		 */
		public function findTableIndexes(Table $table) 
		{				
			$statement = new Statement;
			$statement->showTableIndexes($table->getName());

			$indexes = array_unique(
				$this->connection->query($statement)->fetchAll(
					\PDO::FETCH_CLASS,
					'org\legien\phuice\structures\Index'
				)
			);
			
			foreach($indexes as $key => $index) 
			{			
				$indexes[$key]->setIndexColumns(
					$this->findTableIndexColumns($table, $index)
				);
			}
			
			return $indexes;			
		}	
		
		/**
		 * Get colums of a table index
		 * 
		 * @param Table $table
		 * @param Index $table
		 * @return [StructureGatewayTable\Column]
		 */
		public function findTableIndexColumns(Table $table, Index $index) 
		{				
			$statement = new Statement;
			$statement->showTableIndexes($table->getName());
			$statement->where(new Condition('Key_name', '=', $index->getName()));
			
			$columns = array();
			
			foreach($this->connection->query($statement)->fetchAll(
				\PDO::FETCH_CLASS,
				'org\legien\phuice\structures\IndexColumn'
			) as $indexColumn) 
			{
				$columns[$indexColumn->getName()] = reset($this->findTableColumns($table, $indexColumn->getName()));
			}
						
			return $columns;
		}	
	}