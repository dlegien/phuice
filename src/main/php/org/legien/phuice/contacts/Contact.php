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

	use org\legien\phuice\contacts\Name;

	/**
	 * A person that can be contacted.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	contacts
	 */
	class Contact 
	{
		/**
		 * The name of the contact.
		 * 
		 * @var	Name
		 */
		private $_name;
		
		/**
		 * The email address of the contact.
		 * 
		 * @var	string
		 */
		private $_email;

		/**
		 * Creates a new instance.
		 * 
		 * @param	Name	$name	The name.
		 * @param	string	$email	The email.
		 */
		public function __construct(Name $name, $email) 
		{
			$this->setName($name);
			$this->setEmail($email);
		}

		/**
		 * Sets the name of the contact.
		 * 
		 * @param	Name	$name	The name.
		 * 
		 * @return	Contact
		 */
		public function setName(Name $name) 
		{
			$this->_name = $name;
			return $this;
		}

		/**
		 * Sets the email of the contact.
		 * 
		 * @param	string	$email	The email.
		 * 
		 * @return	Contact
		 */
		public function setEmail($email) 
		{
			$this->_email = $email;
			return $this;
		}

		/**
		 * Returns the name of the contact.
		 * 
		 * @return	Name
		 */
		public function getName() 
		{
			return $this->_name;
		}

		/**
		 * Returns the email of the contact.
		 * 
		 * @return	string
		 */
		public function getEmail() 
		{
			return $this->_email;
		}
	}
