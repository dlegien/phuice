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

	namespace org\legien\phuice\authentication\hashing;
	
	use org\legien\phuice\authentication\HashWrapper;
	
	/**
	 * A hashwrapper based on the crypt function. 
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.authentication
	 * @subpackage	hashing
	 *
	 */
	class CryptHashWrapper implements HashWrapper 
	{
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\authentication\HashWrapper::hashPassword()
		 */
		public function hashPassword($password, $salt = NULL) 
		{
			return $this->hashString($password, $salt);
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\authentication\HashWrapper::hashPassword()
		 */
		public function hashString($string, $salt = NULL) 
		{
			if(!is_null($salt)) 
			{
				return crypt($string, $salt);	
			}
			else 
			{
				return crypt($string);
			}
		}
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\authentication\HashWrapper::verifyPassword()
		 */
		public function verifyPassword($hash, $input) 
		{
			return crypt($input, $hash) == $hash;
		}
	}
