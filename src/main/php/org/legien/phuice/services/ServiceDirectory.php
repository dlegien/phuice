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

	namespace org\legien\phuice\services;

	use org\legien\phuice\services\ServiceException;

	/**
	 * Registers services and parameters.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	services
	 *
	 */
	class ServiceDirectory 
	{
		/**
		 * The registered services.
		 * 
		 * @var array
		 */
		private $_services = array();
		
		/**
		 * The registered parameters.
		 * 
		 * @var array
		 */
		private $_parameters;

		/**
		 * Registers a new service.
		 * 
		 * @param string	$name		The name of the service.
		 * @param mixed		$service	The service description.
		 * @param bool 		$shared		Whether the service is shared.
		 */
		public function register($name, $service, $shared = FALSE) 
		{
			if($shared) 
			{
				$this->_services[$name] = $this->registerShared($service);
			} 
			else 
			{
				$this->_services[$name] = $service;
			}
		}

		/**
		 * Registers a shared service.
		 * 
		 * @param mixed $service	The service description.
		 * @return The service.
		 */
		private function registerShared($service) 
		{
			return function($c) use ($service) 
			{
				static $object;

				if(is_null($object)) 
				{
					$object = $service($c);
				}

				return $object;
			};
		}

		/**
		 * Resolves the given name to a parameter.
		 * 
		 * @param string $name	The parameter name.
		 * @return string
		 */
		private function resolveName($name) 
		{
			if(substr($name, 0, 2) == '%%' && substr($name, strlen($name)-2, 2) == '%%') 
			{
				return $this->getParameter(substr($name,2,strlen($name)-4));
			}
			return $name;
		}

		/**
		 * Tries to resolve the service with the given name.
		 * 
		 * @param string $name	The service name.
		 * @throws ServiceException If the service can not be resolved.
		 * @return The service
		 */
		public function getService($name) 
		{
			$name = $this->resolveName($name);

			if(!isset($this->_services[$name])) 
			{
				throw new ServiceException('Could not resolve service ' . $name . '.');
			}
			return is_callable($this->_services[$name]) ? $this->_services[$name]($this) : $this->_services[$name];
		}

		/**
		 * Returns whether a service with the given name is registered.
		 * 
		 * @param string $name	The name of the service.
		 */
		public function hasService($name) 
		{
			return isset($this->_services[$name]);
		}

		/**
		 * Sets a list of parameters.
		 * 
		 * @param array $parameters The parameters.
		 */
		public function setParameters($parameters = array()) 
		{
			$this->_parameters = $parameters;
		}

		/**
		 * Returns the parameter registered with the given name.
		 * 
		 * @param string $name	The parameter name.
		 * @throws ServiceException	If the parameter could not be resolved.
		 * @return string
		 */
		public function getParameter($name) 
		{
			if(!isset($this->_parameters[$name])) 
			{
				throw new ServiceException('Parameter ' . $name . ' could not be resolved.');
			}
			return $this->_parameters[$name];
		}
	}
