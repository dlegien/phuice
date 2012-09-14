<?php

	namespace org\legien\phuice\routing;

	abstract class AbstractRouter implements Router {

		protected $routes;

		public function __construct(RouteList $routes = NULL) {
			if(is_null($routes)) {
				$this->routes = new RouteList();
			}
			else {
				$this->routes = $routes;
			}
		}

		public function setRoutes(RouteList $routes) {
			$this->routes = $routes;
		}

		public function addRoute(Route $route) {
			$this->routes->add($route);
		}

		public function getRoutes() {
			return $this->routes;
		}
	}
