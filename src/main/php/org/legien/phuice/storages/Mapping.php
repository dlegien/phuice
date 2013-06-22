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
	
	/**
	 * A mapping that links a table to another table using key relations.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	class Mapping
	{
		/**
		 * The source table.
		 * 
		 * @var string
		 */
		private $_sourceTable;
		
		/**
		 * The key relations.
		 * 
		 * @var KeyRelationList
		 */
		private $_keyRelations;
		
		/**
		 * The source model.
		 * 
		 * @var string
		 */
		private $_sourceModel;

		/**
		 * Constructor.
		 * 
		 * @param string			$sourceTable	The name of the source table.
		 * @param KeyRelationList	$keyRelations	The relations between the tables.
		 * @param string			$sourceModel	The source model.
		 */
		public function __construct($sourceTable, KeyRelationList $keyRelations, $sourceModel)
		{
			$this->setSourceTable($sourceTable);
			$this->setKeyRelations($keyRelations);
			$this->setSourceModel($sourceModel);
		}
		
		/**
		 * Sets the source table.
		 * 
		 * @param string $sourceTable The source table.
		 */
		private function setSourceTable($sourceTable)
		{
			$this->_sourceTable = $sourceTable;
		}
		
		/**
		 * Sets the key relations.
		 * 
		 * @param KeyRelationList $relations The list of key relations.
		 */
		private function setKeyRelations(KeyRelationList $relations)
		{
			$this->_keyRelations = $relations;
		}
		
		/**
		 * Sets the source model.
		 * 
		 * @param string $sourceModel The source model.
		 */
		private function setSourceModel($sourceModel)
		{
			$this->_sourceModel = $sourceModel;
		}
		
		/**
		 * Returns the source table.
		 * 
		 * @return string
		 */
		public function getSourceTable()
		{
			return $this->_sourceTable;
		}
		
		/**
		 * Returns the key relations.
		 * 
		 * @return KeyRelationList
		 */
		public function getKeyRelations()
		{
			return $this->_keyRelations;
		}
		
		/**
		 * Returns the source model.
		 * 
		 * @return string
		 */
		public function getSourceModel()
		{
			return $this->_sourceModel;
		}
	}