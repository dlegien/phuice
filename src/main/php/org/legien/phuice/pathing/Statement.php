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

	class Statement 
	{
		private $_type = NULL;
		private $_fields = array();
		private $_tables = NULL;
		private $_joins = array();
		private $_where = NULL;
		private $_order = array();
		private $_values = array();
		private $_hasDistinct = FALSE;
		private $_limit = NULL;
		private $_havings = NULL;
		private $_sets = array();
		private $_groupby = array();
		
		public static $LEFT_JOIN = 0;
		public static $RIGHT_JOIN = 1;
		public static $CROSS_JOIN = 2;
		public static $TYPE_SELECT = 0;
		public static $TYPE_INSERT = 1;
		public static $TYPE_UPDATE = 2;
		public static $TYPE_DELETE = 3;
		
		public function hasDistinct()
		{
			return $this->_hasDistinct;
		}
		
		/**
		 * @deprecated Use SelectSatement instead.
		 * 
		 * @param unknown $what
		 * @param string $alias
		 * @return \org\legien\phuice\pathing\Statement
		 */
		public function select($what, $alias = NULL)
		{
			$this->setType(self::$TYPE_SELECT);			
			if(is_null($alias))
			{
				$alias = $what;
			}
			
			if(stripos($what,'distinct'))
			{
				$this->hasDistinct = TRUE;
			}
			
			$this->_fields[$alias] = $what;
			return $this;
		}
		
		public function having($condition)
		{
			if($condition instanceof Condition || $condition instanceof ConditionGroup)
			{
				$this->_havings = $condition; 
				return $this;				
			}
			throw new \Exception('Can only add Conditions or ConditionGroups to a statement\'s where block');
		}
		
		public function limit($offset, $length)
		{
			if(!is_int($offset) || !is_int($length))
			{
				throw new \Exception('Invalid limit parameters.');
			}
			$this->_limit = array($offset, $length);
			return $this;
		}
		
		public function union(Statement $statement)
		{
			$this->_unions[] = $statement;
			return $this;
		}
		
		public function hasOrdering()
		{
			return count($this->_order) > 0;			
		}
		
		public function hasHaving()
		{
			return !is_null($this->_havings);
		}
		
		public function getHaving()
		{
			return $this->_havings;
		}
		
		public function hasLimit()
		{
			return is_array($this->_limit);
		}
		
		public function getLimitOffset()
		{
			if($this->hasLimit())
			{
				return $this->_limit[0];
			}
			throw new \Exception('Retrieving non-existant limit offset');
		}
		
		public function getLimitLength()
		{
			if($this->hasLimit())
			{
				return $this->_limit[1];
			}
			throw new \Exception('Retrieving non-existant limit length');
		}		
		
		public function insertInto($where)
		{
			$this->setType(self::$TYPE_INSERT);			
			if(is_null($this->_tables))
			{
				$this->_tables = $where;
				return $this;
			}
			throw new \Exception('Statement.insertInto(): You can only call this method once on a statement.');
		}
		
		public function update($where)
		{
			$this->setType(self::$TYPE_UPDATE);			
			if(is_null($this->_tables))
			{
				$this->_tables = $where;
				return $this;				
			}
			throw new \Exception('Statement.update(): You can only call this method once on a statement.');
		}
		
		public function set($field, $value, $quote = TRUE)
		{
			$this->_sets[$field] = $quote ? "'$value'" : $value;
			return $this;
		}
		
		public function field($what)
		{
			$this->_fields[] = $what;
			return $this;
		}
		
		public function value($value, $quoteValue = TRUE)
		{
			$this->_values[] = $quoteValue ? "'$value'" : $value;
			return $this;
		}
		
		public function deleteFrom($where) {
			$this->setType(self::$TYPE_DELETE);			
			if(is_null($this->_tables)) {
				$this->_tables = $where;
				return $this;
			}
			throw new \Exception('Statement.deleteFrom(): This method can only be called once for a Statement.');
		}
		
		private function setType($type) {
			if(is_null($this->_type) && is_int($type)) {
				$this->_type = $type;
			}
			elseif(!is_int($type)) {
				throw new \Exception('Statement.setType(): This method only accepts integer values. ' . $type . ' given.');	
			}
		}
		
		public function from($where) {
			if(is_null($this->_tables)) {
				$this->_tables = $where;
				return $this;
			}
			throw new \Exception('Statement.from(): This method can only be called once for a Statement.');
		}
		
		public function join($what, $on, $type = 1) {
			if(is_int($type)) {
				$this->_joins[] = array($what, $on, $type);
				return $this;
			}
			throw new \Exception('Statement.join(): Invalid parameter type given.');
		}
		
		public function where($condition) {
			if($condition instanceof Condition || $condition instanceof ConditionGroup) {
				$this->_where = $condition; 
				return $this;				
			}
			throw new \Exception('Can only add Conditions or ConditionGroups to a statement\'s where block');
		}
		
		public function orderby($field, $direction = 'ASC') {
			$this->_order[] = "$field $direction";
			return $this;
		}
		
		public function getFields() {
			return $this->_fields;
		}
		
		public function getTables() {
			if(is_null($this->_tables)) {
				throw new \Exception('No source defined');
			}
			return $this->_tables;
		}
		
		public function getJoins() {
			return $this->_joins;
		}
		
		public function getWhere() {
			return $this->hasWhere() ? (string)$this->_where : '';
		}
		
		public function hasWhere() {
			return !is_null($this->_where);
		}
		
		public function getOrder() {
			return $this->_order;
		}
		
		public function getSets() {
			return $this->_sets;
		}

		public function getType() {
			return $this->_type;
		}
		
		public function getValues() {
			return $this->_values;
		}
		
		public function copy() {
			return unserialize(serialize($this)); 
		}
		
		public function getGroupBy() {
			return $this->_groupby;
		}
		
		public function hasGroupBy()
		{
			return (count($this->_groupby) > 0);
		}
		
		public function __toString()
		{
			return 'Statement string representation';
		}
		
		public function groupby($field) {
			$this->_groupby[] = $field;
			return $this;
		}
	}
