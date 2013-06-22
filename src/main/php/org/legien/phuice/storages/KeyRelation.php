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
	 * A relation between two tables represented as a relation between
	 * two keys.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	class KeyRelation
	{
		/**
		 * The source key.
		 * 
		 * @var string
		 */
		private $_sourceKey;
		
		/**
		 * The relation between the keys.
		 * 
		 * @var string
		 */
		private $_relation;
		
		/**
		 * The destination key.
		 * 
		 * @var string
		 */
		private $_destinationKey;
		
		/**
		 * Constructor.
		 * 
		 * @param string $sourceKey			The source key.
		 * @param string $relation			The relation.
		 * @param string $destinationKey	The destination key.
		 */
		public function __construct($sourceKey, $relation, $destinationKey)
		{
			$this->setSourceKey($sourceKey);
			$this->setRelation($relation);
			$this->setDestinationKey($destinationKey);
		}
		
		/**
		 * Sets the source key.
		 * 
		 * @param string $sourceKey The source key.
		 */
		private function setSourceKey($sourceKey)
		{
			$this->_sourceKey = $sourceKey;
		}
		
		/**
		 * Sets the relation.
		 * 
		 * @param string $relation The relation.
		 */
		private function setRelation($relation)
		{
			$this->_relation = $relation;
		}
		
		/**
		 * Sets the destination key.
		 * 
		 * @param string $destinationKey The destination key.
		 */
		private function setDestinationKey($destinationKey)
		{
			$this->_destinationKey = $destinationKey;
		}
		
		/**
		 * Returns the source key.
		 * 
		 * @return string
		 */
		public function getSourceKey()
		{
			return $this->_sourceKey;
		}
		
		/**
		 * Returns the relations.
		 * 
		 * @return string
		 */
		public function getRelation()
		{
			return $this->_relation;
		}
		
		/**
		 * Returns the destination key.
		 * 
		 * @return string
		 */
		public function getDestinationKey()
		{
			return $this->_destinationKey;
		}
	}