<?php

	use org\legien\phuice\routing\Route;
	use org\legien\phuice\testing\TestBase;

	class RouteTest extends TestBase {

		public function setUp() {
			$this->logger = $this->getLogger(__CLASS__);
		}

		public function testSimpleRouteMatching() {

			$this->logger->debug('Testing a simple route matching.');

			$route = new Route(':controller/:action/:id', array(), array());
			$route->matchWith('class/method/1');
			$this->assertTrue($route->isMatched()); 

		}
		
		public function testComplexRouteMatching() {
		
			$this->logger->debug('Testing a complex route matching.');
		
			$route = new Route('settings/?:ref', array(), array());
			$route->matchWith('settings/?msg');
			$this->assertTrue($route->isMatched());
		
		}		
	}
