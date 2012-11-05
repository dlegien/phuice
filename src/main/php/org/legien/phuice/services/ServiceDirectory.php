<?php

	namespace org\legien\phuice\services;

	use org\legien\phuice\services\ServiceException;

	class ServiceDirectory {

		private $_services;
		private $_parameters;

		public function register($name, $service, $shared = FALSE) {
			if($shared) {
				$this->_services[$name] = $this->registerShared($service);
			} else {
				$this->_services[$name] = $service;
			}
		}

		private function registerShared($service) {
			return function($c) use ($service) {
				static $object;

				if(is_null($object)) {
					$object = $service($c);
				}

				return $object;
			};
		}

		private function resolveName($name) {
			if(substr($name, 0, 2) == '%%' && substr($name, strlen($name)-2, 2) == '%%') {
				return $this->getParameter(substr($name,2,strlen($name)-4));
			}
			return $name;
		}

		public function getService($name) {

			$name = $this->resolveName($name);

			if(!isset($this->_services[$name])) {
				throw new ServiceException('Could not resolve service ' . $name . '.');
			}
			return is_callable($this->_services[$name]) ? $this->_services[$name]($this) : $this->_services[$name];
		}

		public function hasService($name) {
			return isset($this->_services[$name]);
		}

		public function setParameters($parameters = array()) {
			$this->_parameters = $parameters;
		}

		public function getParameter($name) {
			if(!isset($this->_parameters[$name])) {
				throw new ServiceException('Parameter ' . $name . ' could not be resolved.');
			}
			return $this->_parameters[$name];
		}
	}
