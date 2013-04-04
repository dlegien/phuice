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
	 * A wrapper for hashing algorithms.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	authentication
	 */
	interface HashWrapper 
	{	
		/**
		 * Verifies a hashed password.
		 * 
		 * @param	string	$hash	The hashed password.
		 * @param	string	$input	The input to check against.
		 * 
		 * @return	boolean
		 */
		public function verifyPassword($hash, $input);
		
		/**
		 * Hashes a password using the given salt.
		 * 
		 * @param	string	$password	The password to hash.
		 * @param	string	$salt		The salt to use.
		 * 
		 * @return	string
		 */
		public function hashPassword($password, $salt);
	}