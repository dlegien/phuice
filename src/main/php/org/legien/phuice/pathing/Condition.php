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

	namespace org\legien\phuice\pathing;

	/**
	 * A condition used to filter in a query.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	pathing
	 *
	 */
	class Condition 
	{
		/**
		 * The field the condition tests.
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
		 * The value to check against.
		 * 
		 * @var mixed
		 */
		private $_value;
		
		/**
		 * Whether the value should be put into quotes.
		 * 
		 * @var bool
		 */
		private $_quoteValue;
		
		/**
		 * Creates a new Condition. If no information about whether to
		 * quote the value is given it will be quoted.
		 * 
		 * @param string	$field		The field to check against.
		 * @param string	$relation	The relation between field and value.
		 * @param string	$value		The value to check against.
		 * @param string 	$quoteValue	Whether to put the value into quotes.
		 */
		public function __construct($field, $relation, $value, $quoteValue = TRUE) 
		{
			$this->setField($field);
			$this->setRelation($relation);
			$this->setValue($value);
			$this->setQuoteValue($quoteValue);			
		}

		/**
		 * Sets whether to quote the value.
		 * 
		 * @param bool $quoteValue	Whether to quote the value.
		 */
		private function setQuoteValue($quoteValue) 
		{
			$this->_quoteValue = $quoteValue;
		}

		/**
		 * Sets the value to check against.
		 * 
		 * @param mixed $value	The value.
		 */
		private function setValue($value) 
		{
			$this->_value = $value;
		}

		/**
		 * The relation between field and value.
		 * 
		 * @param string $relation	The relation.
		 */
		private function setRelation($relation) 
		{
			$this->_relation = $relation;
		}

		/**
		 * Sets the field to check against.
		 * 
		 * @param string $field	The field to check against.
		 */
		private function setField($field) 
		{
			$this->_field = $field;
		}
		
		/**
		 * Returns the condition as a string.
		 * 
		 * @return string
		 */
		public function __toString() 
		{
			return $this->_quoteValue ? "$this->_field $this->_relation '$this->_value'" : "$this->_field $this->_relation $this->_value";
		}	
	}
