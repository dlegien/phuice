<?php

	namespace org\legien\phuice\routing;

	use org\legien\phuice\services\ServiceDirectory;

	class DefaultRouter extends AbstractRouter {

		private $directory;

		public function __construct(ServiceDirectory $directory, RouteList $routes = NULL) {
			parent::__construct($routes);
			$this->directory = $directory;
		}

		public function route($path) {
			
			foreach($this->getRoutes() as $route) {
				$route->matchWith($path);
				if($route->isMatched()) {

					$controller = $route->getParameter('controller');
					$method = $route->getParameter('method');

					$r = new \ReflectionClass($this->directory->getService($controller));
					if($r->hasMethod($method)) {
						$this->__callmethod($this->directory->getService($controller), $r->getMethod($method), $route->getParameters());
					}
					else {
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
				if(isset($args[$param->getName()])) { 
					$pass[] = $args[$param->getName()];
				} 
				else { 
            				$pass[] = $param->getDefaultValue(); 
				}
			} 
			return $method->invokeArgs($clazz, $pass);
		} 
	}
