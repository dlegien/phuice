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

	namespace org\legien\phuice\models;

	/**
	 * Authentication information of a system user.
	 * 
	 * @author		Daniel	Legien
	 * @package		org.legien.phuice
	 * @subpackage	models
	 *
	 */
	class Authentication 
	{
		/**
		 * The unique identification number.
		 * 
		 * @var integer
		 */
		private $id;
		
		/**
		 * The username of the system user.
		 * 
		 * @var string
		 */
		private $username;
		
		/**
		 * The password of the system user.
		 * 
		 * @var string
		 */
		private $password;
		
		/**
		 * The language of the system user.
		 * 
		 * @var string
		 */
		private $language;

		/**
		 * Sets the username of the system user.
		 * 
		 * @param string $username	The username.
		 */
		public function setUsername($username) 
		{
			$this->username = $username;
		}

		/**
		 * Sets the password of the system user.
		 * 
		 * @param string $password	The password.
		 */
		public function setPassword($password) 
		{
			$this->password = $password;
		}

		/**
		 * Returns the username.
		 * 
		 * @return string
		 */
		public function getUsername() 
		{
			return $this->username;
		}

		/**
		 * Returns the password.
		 * 
		 * @return string
		 */
		public function getPassword() 
		{
			return $this->password;
		}

		/**
		 * Sets the unique identification number.
		 * 
		 * @param integer $id
		 */
		public function setId($id) 
		{
			$this->id = $id;
		}
	
		/**
		 * Returns the unique identificaiton number.
		 * 
		 * @return integer
		 */
		public function getId() 
		{
			return $this->id;
		}
		
		/**
		 * Sets the language.
		 * 
		 * @param string $language	The language.
		 */
		public function setLanguage($language) 
		{
			$this->language = $language;
		}
		
		/**
		 * Returns the language.
		 * 
		 * @return string
		 */
		public function getLanguage() 
		{
			return $this->language;
		}
	}
