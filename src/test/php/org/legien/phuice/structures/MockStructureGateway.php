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

	namespace org\legien\phuice\structures;
	
	use org\legien\phuice\structures\StructureGatewayInterface;

	/**
	 * A gateway for database structure information for testing.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	structures
	 *
	 */
	class MockStructureGateway implements StructureGatewayInterface
	{
		/**
		 * The tables in the fake database.
		 * 
		 * @var array
		 */
		private $_tables;
		
		/**
		 * The columns.
		 * 
		 * @var array
		 */
		private $_columns;
		
		/**
		 * The indexes.
		 * 
		 * @var array
		 */
		private $_indexes;
		
		/**
		 * Constructor.
		 * 
		 * @param array $tables The tables.
		 */
		public function __construct($tables, $columns, $indexes)
		{
			$this->_tables = $tables;
			$this->_columns = $columns;
			$this->_indexes = $indexes;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\structures\StructureGatewayInterface::findTableColumns()
		 */
		public function findTableColumns(Table $table, $pattern=false)
		{
			echo __METHOD__ . PHP_EOL;
			if(isset($this->_columns[$table->getName()]))
				return $this->_columns[$table->getName()];
			
			return array();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\structures\StructureGatewayInterface::findTables()
		 */
		public function findTables($pattern = FALSE)
		{
			echo __METHOD__ . PHP_EOL;
			return $this->_tables;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\structures\StructureGatewayInterface::findTableIndexes()
		 */
		public function findTableIndexes(Table $table)
		{
			echo __METHOD__ . PHP_EOL;
			if(isset($this->_indexes[$table->getName()]))
				return $this->_indexes[$table->getName()];
			
			return array();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\structures\StructureGatewayInterface::findTableIndexColumns()
		 */
		public function findTableIndexColumns(Table $table, Index $index)
		{
			echo __METHOD__ . PHP_EOL;
		}
	}