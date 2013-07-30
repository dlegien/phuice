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
	 * A PDO transaction that can be started with the start method, commited
	 * using the commit method and rolled back using the rollback method.
	 * 
	 * Note that these transactions should not be nested!
	 * 
	 * @author Daniel Legien
	 *
	 */
	class PDOTransaction implements ITransaction
	{
		/**
		 * The connection object.
		 * 
		 * @var \PDO
		 */
		private $_connection;
		
		/**
		 * Creates a new transaction object for the given connection object.
		 * 
		 * @param \PDO $connection The connection object.
		 */
		public function __construct(\PDO $connection)
		{
			$this->setConnection($connection);
		}
		
		/**
		 * Sets the connection object.
		 * 
		 * @param \PDO $connection The connection object.
		 */
		private function setConnection(\PDO $connection)
		{
			$this->_connection = $connection;
		}
		
		/**
		 * Returns the connection object.
		 * 
		 * @return \PDO
		 */
		private function getConnection()
		{
			return $this->_connection;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\services\database\ITransaction::start()
		 */
		public function start()
		{
			$this->getConnection()->beginTransaction();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\services\database\ITransaction::commit()
		 */
		public function commit()
		{
			$this->getConnection()->commit();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\services\database\ITransaction::rollback()
		 */
		public function rollback()
		{
			$this->getConnection()->rollback();
		}
	}