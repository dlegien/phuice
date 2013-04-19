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

	namespace org\legien\phuice\authentication;
	
	/**
	 * A container for access information.
	 * 
	 * @author 	Daniel Legien
	 * @package	org.legien.phuice
	 * @subpackage	authentication
	 */
	class AccessBox 
	{	
		/**
		 * The access information
		 * 
		 * @var array
		 */
		private $_access = array();
		
		/**
		 * The saved keys.
		 * 
		 * @var array
		 */
		private $_keys = array();

		/**
		 * Creates a new AccessBox.
		 * 
		 * @param array $access The access information.
		 */
		public function __construct($access = array()) 
		{
			if(is_array($access)) 
			{
				$this->setAccess($access);
				$this->addKeys($access);
			}
		}
		
		/**
		 * Sets the access information.
		 * @param array $access The access information.
		 */
		private function setAccess($access) 
		{
			$this->_access = $access;
		}
		
		/**
		 * Adds the keys.
		 * @param unknown $access The keys.
		 */
		private function addKeys($access) 
		{
			foreach((array)$access as $acc) 
			{
				$this->addKey($acc->getAccessId());
			}
		}
		
		/**
		 * Adds an access.
		 * 
		 * @param Access $access The access.
		 */
		public function addAccess($access) {
			$this->_access[] = $access;
			$this->addKey($access->getAccessId());
		}
		
		/**
		 * Adds a key.
		 * @param string $id The key.
		 */
		private function addKey($id) 
		{
			$this->_keys[$id] = TRUE;
		}
		
		/**
		 * Returns all keys.
		 * @return array
		 */
		public function getKeys() 
		{
			return $this->_keys;
		}
		
		/**
		 * Returns whether the access box knows the specified
		 * key.
		 * @param string $id	The key.
		 * @return boolean
		 */
		public function isIn($id) 
		{
			return array_key_exists($id, $this->getKeys());
		}
	}