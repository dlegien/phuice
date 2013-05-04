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

	namespace org\legien\phuice\storages\database;

	use org\legien\phuice\storages\AuthenticationStorage;
	use org\legien\phuice\storages\AbstractDBStorage;
	use org\legien\phuice\services\database\PDOService;
	use org\legien\phuice\storages\StorageFilter;

	/**
	 * A database storage for authentication information.
	 * 
	 * TODO: Consider moving this to org\legien\phuice\authentiation
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.storages
	 * @subpackage	database
	 *
	 */
	class DBAuthenticationStorage extends AbstractDBStorage implements AuthenticationStorage 
	{
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\AuthenticationStorage::findByUsername()
		 */
		public function findByUsername($username) 
		{
			return parent::find(array(
				new StorageFilter('username', '=', $username)
			));
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\AuthenticationStorage::findByEmail()
		 */
		public function findByEmail($email)
		{
			return parent::find(array(
				new StorageFilter('email', '=', $email)
			));
		}
	}
