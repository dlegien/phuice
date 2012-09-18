<?php

	namespace org\legien\phuice\services;

	class ServiceDirectory {

		private $services;

		public function register($name, $service, $shared = FALSE) {

			if($shared) {
				$this->services[$name] = $this->registerShared($service);
			} else {
				$this->services[$name] = $service;
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

		public function getService($name) {
			return is_callable($this->services[$name]) ? $this->services[$name]($this) : $this->services[$name];
		}

		public function hasService($name) {
			return isset($this->services[$name]);
		}
	}
