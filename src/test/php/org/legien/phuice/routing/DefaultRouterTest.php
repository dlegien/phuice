<?php

	require_once('testloader.php');

	use org\legien\phuice\routing\DefaultRouter;
	use org\legien\phuice\routing\MockCallTarget;
	use org\legien\phuice\routing\Route;
	use org\legien\phuice\services\ServiceDirectory;

	class DefaultRouterTest extends PHPUnit_Framework_Testcase {

		public function setUp() {

			$this->serviceDirectory = new ServiceDirectory();
			$this->serviceDirectory->register('mock', new MockCallTarget());

		}

		public function testSomething() {

			$router = new DefaultRouter($this->serviceDirectory);
			$router->addRoute(new Route(':controller/:method/:id'));

			$router->route('mock/call/2');

			$this->assertTrue($this->serviceDirectory->getService('mock')->gotCalled());
		}
	
	}
