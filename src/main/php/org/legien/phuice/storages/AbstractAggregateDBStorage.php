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
	
	use org\legien\phuice\services\database\IPDOService;
	
	/**
	 * An abstract storage that allows processing models with inheritance.
	 * Override the getMappings() method to inject your own mappings.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	abstract class AbstractAggregateDBStorage extends AbstractDBStorage
	{		
		/**
		 * Constructor.
		 * 
		 * @param IPDOService	$connection The database connection.
		 * @param string		$table		The name of the table.
		 * @param string		$model		The class name of the model.
		 */
		public function __construct(IPDOService $connection, $table, $model)
		{
			parent::__construct($connection, $table, $model);
			$this->setIsAggregate(TRUE);
		}
	}