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

	namespace org\legien\phuice\routing;

	/**
	 * A list of routes.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	routing
	 *
	 */
	class RouteList implements \Iterator 
	{
		/**
		 * The list of routes.
		 * 
		 * @var array
		 */
		private $routes;
		
		/**
		 * The indexes.
		 * 
		 * @var array
		 */
		private $indexes;
		
		/**
		 * The current position of the iterator.
		 * 
		 * @var integer
		 */
		private $position = 0;

		/**
		 * Creates a new list of routes.
		 */
		public function __construct() 
		{
			$this->routes = array();
			$this->indexes = array();
			$this->position = 0;
		}

		/**
		 * Adds a route to the list.
		 * @param Route 	$route	The route.
		 */
		public function add(Route $route) 
		{
			$this->routes[$route->getRoute()] = $route;
			$this->indexes[] = $route->getRoute();
		}

		/**
		 * (non-PHPdoc)
		 * @see Iterator::rewind()
		 */
		public function rewind() 
		{
			$this->position = 0;
		}

		/**
		 * (non-PHPdoc)
		 * @see Iterator::current()
		 */
		public function current() 
		{
			return $this->routes[$this->indexes[$this->position]];
		}

		/**
		 * (non-PHPdoc)
		 * @see Iterator::key()
		 */
		public function key() 
		{
			return $this->position;
		}

		/**
		 * (non-PHPdoc)
		 * @see Iterator::next()
		 */
		public function next() 
		{
			++$this->position;
		}

		/**
		 * (non-PHPdoc)
		 * @see Iterator::valid()
		 */
		public function valid() 
		{
			return isset($this->indexes[$this->position]);
		}
	}
