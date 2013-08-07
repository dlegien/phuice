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
	 * A route that can be used by a Router and fowards the
	 * call to a controller.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	routing
	 * 
	 */
	class Route 
	{
		/**
		 * Whether the route was matched.
		 * 
		 * @var bool
		 */
		protected $isMatched = FALSE;
		
		/**
		 * Whether the route was processed.
		 * 
		 * @var bool
		 */
		protected $isProcessed = FALSE;
		
		/**
		 * A text representation of the route.
		 * 
		 * @var string
		 */
		protected $route;
		
		/**
		 * The target of the route. The definition of the controller
		 * and methods to call go here.
		 * 
		 * @var array
		 */
		protected $target;
		
		/**
		 * Conditions that have to be met in order for the routing
		 * to match.
		 * 
		 * @var array
		 */
		protected $conditions;
		
		/**
		 * Parameters of the route that will be used when calling
		 * the controller methods.
		 * 
		 * @var array
		 */
		protected $parameters;

		/**
		 * Initializes a new Route.
		 * 
		 * @param string	$route		The text representation of the route.
		 * @param array 	$target		The target of the route.
		 * @param array		$conditions	The conditions of the route.
		 */
		public function __construct($route, $target = array(), $conditions = array()) 
		{
			$this->route = $this->prepareRoute($route);
			$this->target = $target;
			$this->conditions = $conditions;
			$this->parameters = array();
		}
		
		/**
		 * Prepares the route for processing.
		 * 
		 * @param string 	$route	The route.
		 * 
		 * @return string
		 */
		private function prepareRoute($route) 
		{
			return str_replace('?', '\?', $route);
		}

		/**
		 * Returns whether the route was matched.
		 * 
		 * @return boolean
		 */
		public function isMatched() 
		{
			return $this->isMatched;
		}

		/**
		 * Tries to match the route with the given path.
		 * 
		 * @param string	$path	The path.
		 */
		public function matchWith($path) 
		{			
			$parameterNames = array();
			preg_match_all('@:([\w]+)@', $this->route, $parameterNames, PREG_PATTERN_ORDER);
			if(strpos($this->route, '*') !== FALSE)
			{
				$this->route = str_replace('*', '(.*)', $this->route);				
			}
			
			$regex = preg_replace_callback('@:[\w]+@', array($this, 'regex'), $this->route);
			$regex .= '/?';
	
			if(preg_match('@^'.$regex.'$@', $path, $parameters)) 
			{
				foreach($parameterNames[0] as $index => $value)
				{	
					$val = urldecode($parameters[$index+1]);
					if(strpos($val, "="))
					{
						$param = explode("=", $val);
						$this->parameters[$param[0]] = $param[1];
					}
					else
					{
						$this->parameters[substr($value,1)] = urldecode($parameters[$index+1]);						
					}					
				}
				
				foreach($this->target as $key => $value)
				{
					$this->parameters[$key] = $value;
				}
				$this->setMatched(TRUE);
			}
			
			$this->setProcessed(TRUE);
		}

		/**
		 * Sets the route as matched or not matched.
		 * 
		 * @param bool 	$matched 	Whether the route matched.
		 */
		protected function setMatched($matched) 
		{
			$this->isMatched = $matched;
		}

		/**
		 * Sets the route as processed or not processed.
		 * 
		 * @param bool	$processed	Whether the route was processed.
		 */
		protected function setProcessed($processed) 
		{
			$this->isProcessed = $processed;
		}

		/**
		 * Returns whether the route was processed.
		 * 
		 * @return bool
		 */
		private function isProcessed() 
		{
			return $this->isProcessed;
		}

		/**
		 * Returns the parameters of the route if it was
		 * matched and processed.
		 * 
		 * @throws \Exception If the route wasn't processed or didn't match.
		 * @return array
		 */
		public function getParameters() 
		{
			if($this->isProcessed() && $this->isMatched()) 
			{
				return $this->parameters;
			} 
			throw new RouteException('Has to be processed and matched before retrieving parameters.');
		}

		/**
		 * Returns the parameter with the given name or null if the parameter
		 * is not set.
		 * 
		 * @param	string	$name	The name of the parameter.
		 * 
		 * @return mixed
		 */
		public function getParameter($name) 
		{
			if(isset($this->parameters[$name])) 
			{
				return $this->parameters[$name];
			}
			return NULL;
		}	

		/**
		 * Returns the text representation of the route.
		 * 
		 * @return string
		 */
		public function getRoute() 
		{
			return $this->route;
		}

		/**
		 * Returns the regex for matching.
		 * 
		 * @param array 	$matches	The matches of the search.
		 * @return string
		 */
		protected function regex($matches) 
		{
			return '([a-zA-Z0-9_\+\-\=\.%]+)';
		}
	}
