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
	 * An evaluator for statements. Implementing classes take care of
	 * translating the statement into the database query language.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.pathing
	 * @subpackage	evaluators
	 *
	 */
	interface StatementEvaluator 
	{	
		/**
		 * Evaluates the given statement and returns it's text
		 * representation in the proper database query language.
		 * 
		 * @param Statement $statement The statement.
		 * 
		 * @return string
		 */
		public function evaluate(Statement $statement);			
	}
