<?php
	
	namespace org\legien\phuice\routing;

	class RouteList implements \Iterator {

		private $routes;
		private $indexes;
		private $position = 0;

		public function __construct() {
			$this->routes = array();
			$this->indexes = array();
			$this->position = 0;
		}

		public function add(Route $route) {
			$this->routes[$route->getRoute()] = $route;
			$this->indexes[] = $route->getRoute();
		}

		public function rewind() {
			$this->position = 0;
		}

		function current() {
			return $this->routes[$this->indexes[$this->position]];
		}

		function key() {
			return $this->position;
		}

		function next() {
			++$this->position;
		}

		public function valid() {
			return isset($this->indexes[$this->position]);
		}
	}
