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
		 * @var ServiceDirectory
		 */
		private $directory;

		public function __construct(ServiceDirectory $directory, RouteList $routes = NULL) 
		{
			parent::__construct($routes);
			$this->directory = $directory;
		}

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

		public function __callmethod($clazz, \ReflectionMethod $method, array $args = array()) 
		{ 
			$pass = array(); 
			foreach($method->getParameters() as $param) { 
          			/* @var $param ReflectionParameter */ 
          		try
          		{
					if(isset($args[$param->getName()])) { 
						$pass[] = $args[$param->getName()];
					} 
					else { 
    	        		$pass[] = $param->getDefaultValue(); 
					}          			
          		}
				catch(\Exception $e)
				{
					var_dump($param);
				}
			}
			return $method->invokeArgs($clazz, $pass);
		} 
	}
