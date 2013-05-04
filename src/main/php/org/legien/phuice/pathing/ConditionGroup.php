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
	 * A group of conditions.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	pathing
	 *
	 * @todo		Consider turning this class abstract.
	 */
	class ConditionGroup 
	{
		/**
		 * The registered children.
		 * 
		 * @var array
		 */
		protected $children = array();
		
		/**
		 * Adds another ConditionGroup or a Condition to the group.
		 * 
		 * @param 	mixed 	$child	The Condition or ConditionGroup
		 * @throws PathingException If the child is not a ConditionGroup or Condition
		 * @return ConditionGroup
		 */
		public function set($child) 
		{
			if($child instanceof ConditionGroup || $child instanceof Condition) 
			{
				$this->children[] = $child;
				return $this;				
			}
			throw new PathingException('A ConditionGroup can only accept other ConditionGroups or Conditions as children.');		
		}
		
		/**
		 * Returns the registered children.
		 * 
		 * @return array
		 */
		public function getChildren() 
		{
			return $this->children;
		}
		
		/**
		 * Returns the join operation.
		 * 
		 * @return string
		 */
		public function getJoinOperation() 
		{
			return $this->joinOperation;
		}
		
		/**
		 * Sets the join operation.
		 * 
		 * @param string $joinOperation	The join operation.
		 * @return ConditionGroup
		 */
		public function setJoinOperation($joinOperation) 
		{
			$this->joinOperation = $joinOperation;
			return $this;	
		}
		
		/**
		 * Returns the ConditionGroup as a string.
		 * 
		 * @return string
		 */
		public function __toString() 
		{
			foreach($this->getChildren() as $child) 
			{
				if($child instanceof Condition) 
				{
					$statements[] = (string)$child;
				}
				elseif($child instanceof ConditionGroup) 
				{
					$statements[] = '('. $child .')';					
				}
			}
			return '' . join(' ' . $this->getJoinOperation() . ' ', $statements) . '';			
		}
	}
