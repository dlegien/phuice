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
	 * An abstract router that bundles methods required by all
	 * routers.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	routing
	 *
	 */
	abstract class AbstractRouter implements Router 
	{
		/**
		 * The list of routes.
		 * 
		 * @var RouteList
		 */
		protected $routes;

		/**
		 * Initializes the router.
		 * 
		 * @param RouteList	$routes	The routes.
		 */
		public function __construct(RouteList $routes = NULL) 
		{
			if(is_null($routes)) 
			{
				$this->routes = new RouteList();
			}
			else 
			{
				$this->routes = $routes;
			}
		}

		/**
		 * Sets the routes of the router.
		 * 
		 * @param RouteList $routes	The routes.
		 */
		public function setRoutes(RouteList $routes) 
		{
			$this->routes = $routes;
		}

		/**
		 * Adds a route to the list of routes.
		 * 
		 * @param Route $route	The route to add.
		 */
		public function addRoute(Route $route) 
		{
			$this->routes->add($route);
		}

		/**
		 * Returns all known routes.
		 * 
		 * @return RouteList
		 */
		public function getRoutes() 
		{
			return $this->routes;
		}
	}
