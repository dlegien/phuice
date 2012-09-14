<?php

	namespace org\legien\phuice\services;

	class ServiceDirectory {

		private $services;

		public function register($name, $service) {
			$this->services[$name] = $service;
		}

		public function getService($name) {
			return $this->services[$name];
		}
	}
