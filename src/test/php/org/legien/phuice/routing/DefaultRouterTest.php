<?php

	use org\legien\phuice\routing\DefaultRouter;
	use org\legien\phuice\routing\MockCallTarget;
	use org\legien\phuice\routing\Route;
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
	
	}
