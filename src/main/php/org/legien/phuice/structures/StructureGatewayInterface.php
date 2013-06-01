<?php

	namespace org\legien\phuice\structures;
	
	/**
	 * The interface of a structure gateway.
	 * 
	 * @author 		Rüdiger Willmann <r.willmann@design-it.de>
	 * @package		org.legien.phuice
	 * @subpackage	structures
	 * 
	 */
	interface StructureGatewayInterface
	{		
		/**
		 * Returns a list of all tables.
		 *
		 * @return array
		 */
		public function findTables($pattern = FALSE);
		
		/**
		 * Get table columns
		 *
		 * @param Table $table
		 * @param string $pattern
		 * @return Column
		 */
		public function findTableColumns(Table $table, $pattern=false);
		
		/**
		 * Returns the indexes of the given table.
		 *
		 * @param Table $table The table.
		 *
		 * @return [Index]
		 */
		public function findTableIndexes(Table $table);
		
		/**
		 * Get colums of a table index
		 *
		 * @param Table $table
		 * @param Index $table
		 * @return [StructureGatewayTable\Column]
		 */
		public function findTableIndexColumns(Table $table, Index $index);		
	}