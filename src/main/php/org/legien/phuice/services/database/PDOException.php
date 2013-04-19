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

	namespace org\legien\phuice\services\database;
	
	/**
	 * An exception that indicates that there was a database error that
	 * prevented a query from being successfully executed.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice.services
	 * @subpackage	database
	 * 
	 */
	class PDOException extends \Exception
	{
		/**
		 * Creates a new instance of this exception.
		 * 
		 * @param string $message	The exception message.
		 */
		public function __construct($message)
		{
			parent::__construct('PDOException: ' + $message);
		}
	}