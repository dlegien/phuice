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

	namespace org\legien\phuice;

	/**
	 * A wrapper for a request sent to the system.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 *
	 */
	class Request 
	{
		/**
		 * The parameters of the request.
		 * 
		 * @var array
		 */
		private $_parameters = array();

		/**
		 * Creates a new Request.
		 * 
		 * @param array $get	The GET parameters.
		 * @param array $post	The POST parameters.
		 */
		public function __construct(array $get, array $post) 
		{
			foreach($get as $key => $value) 
			{
				$this->_parameters[$key] = $value;
			}
			foreach($post as $key => $value) 
			{
				$this->_parameters[$key] = $value;
			}
		}

		/**
		 * Returns the parameter with the given name if it was set or
		 * NULL otherwise.
		 * 
		 * @param string $name	The name of the parameter.
		 * 
		 * @return mixed
		 */
		public function getParameter($name) 
		{
			if(isset($this->_parameters[$name])) 
			{
				return $this->_parameters[$name];
			}
			return NULL;
		}
		
		
		/**
		 * Returns a set of parameters if there are any
		 * NULL otherwise.
		 *
		 *
		 * @return mixed
		 */
		public function getParameters()
		{
			return $this->_parameters;
		}
	}
