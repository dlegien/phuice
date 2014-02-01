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
		 * The state of the system user (active or inactive).
		 *
		 * @var boolean
		 */
		private $active;

		/**
		 * The current validity of the user password (1 = has to be reset, 0 = ok).
		 *
		 * @var int
		 */
		private $reset_password;

		/**
		 * The current token for the forget password functionality.
		 *
		 * @var string
		 */
		private $token;


		/**
		 * The current token timestamp.
		 *
		 * @var date
		 */
		private $token_time;


		/**
		 * Returns an array representation of the model.
		 * 
		 * @return	array
		 */
		public function toArray() 
		{
			$return = array();
			foreach(array_keys(get_class_vars(__CLASS__)) as $field)
			{
				$return[$field] = $this->$field;
			}
			return $return;
		}

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
		 * Sets login_password to the given value.
		 * 
		 * @param	int	$reset_password	
		 */
		public function setResetPassword($reset_password) 
		{
			$this->reset_password = (int)$reset_password;
		}


		/**
		 * Sets token to the given value.
		 * 
		 * @param	string	$token	
		 */
		public function setToken($token) 
		{
			$this->token = $token;
		}

		/**
		 * Sets token_time to the given value.
		 * 
		 * @param	string	$token_time	
		 */
		public function setTokenTime($token_time) 
		{
			$this->token_time = $token_time;
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
		
		
		/**
		 * Sets the active flag.
		 *
		 * @param boolean $active.	The state.
		 */
		public function setActive($active)
		{
			$this->active = $active;
		}
		
		/**
		 * Returns the state of the system user.
		 *
		 * @return boolean
		 */
		public function isActive()
		{
			return $this->active;
		}

		/**
		 * Returns the value of reset_password.
		 * 
		 * @return	boolean
		 */
		public function hasToResetPassword() 
		{
			return $this->reset_password == 1;
		}


		/**
		 * Gets token associated to the user.
		 * 
		 * @param	string	$token	
		 */
		public function getToken() 
		{
			return (string)$this->token;
		}

		/**
		 * Gets token_time associated to the users token.
		 * 
		 * @param	string	$token_time	
		 */
		public function getTokenTime() 
		{
			return (string)$this->token_time;
		}
	}
