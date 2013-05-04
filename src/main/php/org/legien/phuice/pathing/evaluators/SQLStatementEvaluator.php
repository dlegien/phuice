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

	namespace org\legien\phuice\pathing\evaluators;

	use org\legien\phuice\pathing\Statement;

	/**
	 * An evaluator for statements that translates a statement into an
	 * SQL compatible query.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.pathing
	 * @subpackage	evaluators
	 *
	 */
	class SQLStatementEvaluator implements StatementEvaluator 
	{
		/**
		 * Mappings for translating the joins
		 * 
		 * @var array
		 */	
		private $joins;

		/**
		 * Initializes the evaluator.
		 * 
		 */
		public function __construct() 
		{
			$this->joins = array(
				Statement::$LEFT_JOIN => 'LEFT',
				Statement::$RIGHT_JOIN => 'RIGHT',
				Statement::$CROSS_JOIN => 'CROSS'
			);		
		}
		
		/**
		 * Performs an evaluation of the provided Statement's fields. This method is
		 * used in the select statement evaluation.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */
		private function evaluateWhat(Statement $statement)
		{
			$fields = $statement->getFields();
			
			foreach($fields as $alias => $what)
			{
				$whats[] = $alias == $what ? $what : "$what AS $alias";				
			}
			
			return count($fields) > 0 ? implode(', ', $whats) : '*';
		}
		
		/**
		 * Performs an evaluation of the provided Statement's fields. This method is
		 * used in the insert statement evaluation.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */		
		private function evaluateFields(Statement $statement)
		{
			$fields = $statement->getFields();
			
			return '`'.implode('`,`',$fields).'`';
		}

		/**
		 * Performs an evaluation of the provided Statement's sets. This method is
		 * used in the update statement evaluation.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */				
		private function evaluateSets(Statement $statement)
		{
			$sets = $statement->getSets();
			
			foreach($sets as $field => $value)
			{
				$s[] = "$field = $value";
			}
			return implode(', ', $s);
		}
		
		/**
		 * Performs an evaluation of the provided Statement's values. This method is
		 * used in the insert statement evaluation.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */				
		private function evaluateValues(Statement $statement)
		{
			$values = $statement->getValues();
			
			return implode(',',$values);
		}
		
		/**
		 * Performs an evaluation of the provided Statement's tables. This method is
		 * used in all statement evaluations.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */				
		private function evaluateTables(Statement $statement)
		{
			return $statement->getTables();
		}
		
		/**
		 * Returns the corresponding integer value of the Statement class associated
		 * with the integer value passed or throws an Exception.
		 * 
		 * @param	integer	$joinType	The type of the join.
		 * 
		 * @return	integer
		 * @throws	\Exception
		 */				
		private function getJoin($joinType)
		{
			if(isset($this->joins[$joinType]))
			{
				return $this->joins[$joinType];
			}
			throw new \Exception('SQLStatementEvaluator.getJoin(): Unsupported join type ' . $joinType . ' called.');
		}
		
		/**
		 * Evalutes the joins of the provided Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on
		 * 
		 * @return	string
		 */
		private function evaluateJoins(Statement $statement)
		{
			$where = '';
						
			foreach($statement->getJoins() as $join)
			{
				$where .= ' '.$this->getJoin($join[2]).' JOIN '.$join[0].' ON '.$join[1];
			}
			return $where;
		}
				
		/**
		 * Evalutes the where conditions of the provided Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */
		private function evaluateWhere(Statement $statement)
		{
			if($statement->hasWhere())
			{
				return ' WHERE ' . $statement->getWhere();
			}
			return '';			
		}
		
		/**
		 * Evaluates the ordering information of the provided Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */
		private function evaluateOrdering(Statement $statement)
		{
			if($statement->hasOrdering())
			{
				$order = ' ORDER BY ' . implode(', ', $statement->getOrder());
				return $order;
			}			
		}
		
		/**
		 * Evaluates the limiting information of the provided Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */
		private function evaluateLimit(Statement $statement)
		{
			if($statement->hasLimit())
			{
				return ' LIMIT ' . $statement->getLimitOffset() . ',' . $statement->getLimitLength();
			}
			return '';
		}
		
		/**
		 * Evaluates the having conditions of the provided Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */
		private function evaluateHaving(Statement $statement)
		{
			if($statement->hasHaving())
			{
				return ' HAVING ' . $statement->getHaving();
			}
			return '';	
		}
		
		/**
		 * Evaluates the group by information of the provided Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return	string
		 */
		private function evaluateGroupBy(Statement $statement)
		{
			return $statement->hasGroupBy() ? implode(',', $statement->getGroupBy()) : '';
		}
		
		/**
		 * Evaluates a select statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return 	string
		 */
		private function evaluateSelect(Statement $statement)
		{
			$FIELDS = $this->evaluateWhat($statement);
			$TABLES = $this->evaluateTables($statement);
			$TABLES .= $this->evaluateJoins($statement);
			$WHERE = $this->evaluateWhere($statement);
			$GROUPBY = $this->evaluateGroupBy($statement);
			$HAVING = $this->evaluateHaving($statement);
			$ORDERBY = $this->evaluateOrdering($statement);
			$LIMIT = $this->evaluateLimit($statement);
						
			return 			
				'SELECT ' . $FIELDS . 
				' FROM '. $TABLES . 
				$WHERE .
				$GROUPBY .
				$HAVING .
				$ORDERBY .
				$LIMIT 
			;			
		}
		
		/**
		 * Evaluates an insert Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return 	string
		 */
		private function evaluateInsert(Statement $statement)
		{			
			$TABLES = $this->evaluateTables($statement);
			$FIELDS = $this->evaluateFields($statement);
			$VALUES = $this->evaluateValues($statement);
			
			return
				'INSERT INTO '. $TABLES .
				' (' . $FIELDS . ') 
				VALUES (' . $VALUES . ')'
			;				
		}
		
		/**
		 * Evaluates an update Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return 	string
		 */		
		private function evaluateUpdate(Statement $statement)
		{
			$TABLES = $this->evaluateTables($statement);
			$SETS = $this->evaluateSets($statement);
			$WHERE = $this->evaluateWhere($statement);			
			
			return 
				'UPDATE ' . $TABLES .
				' SET ' . $SETS .
				$WHERE;
		}
		
		/**
		 * Evaluates a delete Statement.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return 	string
		 */		
		private function evaluateDelete(Statement $statement)
		{
			$TABLES = $this->evaluateTables($statement);
			$WHERE = $this->evaluateWhere($statement);	
						
			return
				'DELETE FROM '. $TABLES .
				$WHERE;
		}
		
		/**
		 * Evaluates the provided statement based on its type.
		 * 
		 * @param	Statement	$statement	The Statement the evaluation should be
		 * 									based on.
		 * 
		 * @return 	string
		 * @throws	\Exception
		 */ 
		public function evaluate(Statement $statement)
		{
			switch ($statement->getType())
			{
				case Statement::$TYPE_SELECT:					
					return $this->evaluateSelect($statement);
				case Statement::$TYPE_INSERT:					
					return $this->evaluateInsert($statement);
				case Statement::$TYPE_UPDATE:					
					return $this->evaluateUpdate($statement);
				case Statement::$TYPE_DELETE:					
					return $this->evaluateDelete($statement);														
				default:
					throw new \Exception('Unrecognized statement type');
			}						
		}
	}
	
