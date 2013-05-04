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
	 * An ordering that can be passed to an AbstractDBStorage to influence
	 * the ordering of the results.
	 * 
	 * @deprecated	Use org\legien\phuice\pathing\Ordering in conjunction with
	 * 				org\legien\phuice\repositories\AbstractRepository instead.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	class StorageOrdering
	{
		/**
		 * The field to order by.
		 * 
		 * @var string
		 */
		private $_field;
		
		/**
		 * The direction to order in.
		 * 
		 * @var string
		 */
		private $_direction;
		
		/**
		 * Creates a new ordering.
		 * 
		 * @param string	$field		The field to order by.
		 * @param string	$direction	The direction of the ordering.
		 */
		public function __construct($field, $direction)
		{
			$this->setField($field);
			$this->setDirection($direction);
		}
		
		/**
		 * Sets the field to order by.
		 * 
		 * @param string $field The field.
		 */
		private function setField($field)
		{
			$this->_field = $field;
		}
		
		/**
		 * Returns the field to order by.
		 * 
		 * @return string
		 */
		public function getField()
		{
			return $this->_field;
		}
		
		/**
		 * Sets the direction to order in.
		 * 
		 * @param string $direction The direction.
		 */
		private function setDirection($direction)
		{
			$this->_direction = $direction;
		}
		
		/**
		 * Returns the direction to order in.
		 * 
		 * @return string
		 */
		public function getDirection()
		{
			return $this->_direction;
		}
	}
