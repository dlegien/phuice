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

	namespace org\legien\phuice\contacts;

	/**
	 * A name of a person
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.
	 * @subpackage	contacts
	 */
	class Name 
	{
		/**
		 * @var	string
		 */
		private $_firstname;
		
		/**
		 * @var	string
		 */
		private $_lastname;

		/**
		 * Creates a new instance.
		 * 
		 * @param	string	$firstname	The firstname.
		 * @param	string	$lastname	The lastname.
		 */
		public function __construct($firstname, $lastname) 
		{
			$this->setFirstname($firstname);
			$this->setLastname($lastname);
		}
		
		/**
		 * Sets the firstname to the given name.
		 * 
		 * @param	string	$firstname	The firstname.
		 */
		public function setFirstname($firstname) 
		{
			$this->_firstname = $firstname;
		}

		/**
		 * Sets the lastname to the given name.
		 * 
		 * @param	string	$lastname	The lastname.
		 */
		public function setLastname($lastname) 
		{
			$this->_lastname = $lastname;
		}

		/**
		 * Returns the firstname.
		 * 
		 * @return	string
		 */
		public function getFirstname() 
		{
			return $this->_firstname;
		}

		/**
		 * Returns the lastname.
		 * 
		 * @return	string
		 */
		public function getLastname() 
		{
			return $this->_lastname;
		}
	}
