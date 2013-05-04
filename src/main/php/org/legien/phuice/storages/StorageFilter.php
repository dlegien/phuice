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
	 * A filter that can be passed to the abstract storage in order to
	 * filter the results of a request.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 * 
	 * @deprecated	Use org\legien\phuice\pathing\Condition in conjunction with
	 * 				org\legien\phuice\repositories\AbstractRepository instead.
	 *
	 */
	class StorageFilter 
	{
		/**
		 * The field to filter against.
		 * 
		 * @var string
		 */
		private $_field;
		
		/**
		 * The relation between field and value.
		 * 
		 * @var string
		 */
		private $_relation;
		
		/**
		 * The value to filter against.
		 * 
		 * @var mixed
		 */
		private $_value;
		
		/**
		 * Creates a new filter.
		 * 
		 * @param string	$field		The field to filter against.
		 * @param string	$relation	The relation between field and value.
		 * @param mixed		$value		The value to filter against.
		 */
		public function __construct($field, $relation, $value) 
		{
			$this->setField($field);
			$this->setRelation($relation);
			$this->setValue($value);
		}
		
		/**
		 * Sets the field to filter against.
		 * 
		 * @param string $field The field.
		 */
		private function setField($field) 
		{
			$this->_field = $field;
		}

		/**
		 * Sets the relation between filter and value.
		 * 
		 * @param string $relation The relation.
		 */
		private function setRelation($relation) 
		{
			$this->_relation = $relation;
		}

		/**
		 * Sets the value to filter against.
		 * 
		 * @param mixed $value The value.
		 */
		private function setValue($value) 
		{
			$this->_value = $value;
		}

		/**
		 * Returns the field to filter against.
		 * 
		 * @return string
		 */
		public function getField() 
		{
			return $this->_field;
		}
		
		/**
		 * Returns the relation between the field and value.
		 * 
		 * @return string
		 */
		public function getRelation() 
		{
			return $this->_relation;
		}
		
		/**
		 * Returns the value to filter against.
		 * 
		 * @return mixed
		 */
		public function getValue() 
		{
			return $this->_value;
		}
	}
