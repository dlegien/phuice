<?php

	use org\legien\phuice\routing\DefaultRouter;
	use org\legien\phuice\routing\MockCallTarget;
	use org\legien\phuice\routing\Route;
	use org\legien\phuice\routing\RouteList;
	use org\legien\phuice\services\ServiceDirectory;
	use org\legien\phuice\testing\TestBase;

	class DefaultRouterTest extends TestBase {

		public function setUp() {

			$this->logger = $this->getLogger(__CLASS__);
			$this->serviceDirectory = new ServiceDirectory;
			$this->serviceDirectory->register('mock', new MockCallTarget());
		}

		public function testSuccessfulServiceCall() {

			$this->logger->debug('Testing if a specified service is called correctly.');

			$router = new DefaultRouter($this->serviceDirectory);
			$router->addRoute(new Route(':controller/:method/:id'));

			$router->route('mock/call/2');

			$this->assertTrue($this->serviceDirectory->getService('mock')->gotCalled());
		}
		
		public function testAddingListOfRoutes() {
			
			$this->logger->debug('Testing if a list of routes can be added to the router.');
			
			$routeList = new RouteList();
			$routeList->add(new Route('abc'));
			$routeList->add(new Route('def'));

			$routeList2 = new RouteList();
			$routeList2->add(new Route('ghi'));

			$router = new DefaultRouter($this->serviceDirectory, $routeList);

			$routecount = 0;
			foreach($router->getRoutes() as $route) {
				$routecount++;
			}

			$this->assertEquals(2, $routecount);

			$router->setRoutes($routeList2);

			$routecount2 = 0;
			foreach($router->getRoutes() as $route) {
				$routecount2++;
			}

			$this->assertEquals(1, $routecount2);
		}
	
	}
