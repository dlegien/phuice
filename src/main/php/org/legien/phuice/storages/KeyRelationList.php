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
	 * A list of relations.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	class KeyRelationList implements \Iterator
	{
		/**
		 * The list of relations.
		 *
		 * @var array
		 */
		private $_relations;
		
		/**
		 * The current position of the iterator.
		 *
		 * @var integer
		 */
		private $_position = 0;
		
		/**
		 * Creates a new list of relations.
		 * 
		 * @param array $relations The relations.
		 */
		public function __construct($relations = array())
		{
			$this->setRelations($relations);
			$this->_position = 0;
		}
		
		/**
		 * Sets the relations.
		 * 
		 * @param array $relations The relations.
		 */
		private function setRelations($relations)
		{
			$this->_relations = $relations;
		}
		
		/**
		 * Adds a route to the list.
		 * @param Route 	$route	The route.
		 */
		public function add(KeyRelation $relation)
		{
			$this->_relations[] = $relation;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see Iterator::rewind()
		 */
		public function rewind()
		{
			$this->_position = 0;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see Iterator::current()
		 */
		public function current()
		{
			if (isset($this->_relations[$this->_position]))
			{
				return $this->_relations[$this->_position];
			}
			
			return NULL;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see Iterator::key()
		 */
		public function key()
		{
			return $this->_position;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see Iterator::next()
		 */
		public function next()
		{
			++$this->_position;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see Iterator::valid()
		 */
		public function valid()
		{
			return isset($this->_relations[$this->_position]);
		}		
	}