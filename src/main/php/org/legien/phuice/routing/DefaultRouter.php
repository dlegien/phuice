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

	use org\legien\phuice\services\ServiceDirectory;

	/**
	 * A router for URL routing.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	routing
	 */
	class DefaultRouter extends AbstractRouter 
	{
		/**
		 * The directory where available services are registered.
		 * 
		 * @var ServiceDirectory
		 */
		private $directory;

		/**
		 * Creates a new DefaultRouter instance.
		 * 
		 * @param ServiceDirectory	$directory	The directory for service references.
		 * @param RouteList 		$routes		The list of available routes.
		 */
		public function __construct(ServiceDirectory $directory, RouteList $routes = NULL) 
		{
			parent::__construct($routes);
			$this->directory = $directory;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\routing\Router::route()
		 */
		public function route($path) 
		{	
			foreach($this->getRoutes() as $route) 
			{
				$route->matchWith($path);
				if($route->isMatched()) 
				{

					$controller = $route->getParameter('controller');
					$method = $route->getParameter('method');

					$r = new \ReflectionClass($this->directory->getService($controller));
					if($r->hasMethod($method)) 
					{
						$this->__callmethod($this->directory->getService($controller), $r->getMethod($method), $route->getParameters());
					}
					else 
					{
						throw new \Exception('404');
					}
				}
			}
		}

		/**
		 * Calls a method of a class. 
		 * 
		 * @param object 			$object	The instance of the class to call the method on.
		 * @param \ReflectionMethod $method	The method of the class to call.
		 * @param array 			$args	The arguments the method should be called with.
		 * 
		 * @return mixed
		 */
		private function __callmethod($object, \ReflectionMethod $method, array $args = array()) 
		{ 
			$pass = array(); 
			foreach($method->getParameters() as $param) 
			{
          		try
          		{
					if(isset($args[$param->getName()])) 
					{ 
						$pass[] = $args[$param->getName()];
					} 
					else 
					{ 
    	        		$pass[] = $param->getDefaultValue(); 
					}          			
          		}
				catch(\Exception $e)
				{
					var_dump($param);
				}
			}
			return $method->invokeArgs($object, $pass);
		} 
	}
