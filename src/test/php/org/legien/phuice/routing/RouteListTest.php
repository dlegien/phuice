<?php

	use org\legien\phuice\routing\RouteList;
	use org\legien\phuice\routing\Route;
	use org\legien\phuice\testing\TestBase;

	class RouteListTest extends TestBase {

		public function setUp() {
			$this->logger = $this->getLogger(__CLASS__);
		}

		public function testSimpleRouteListCreation() {

			$this->logger->debug('Testing if a routeliste can be constructed and used correctly.');

			$routelist = new RouteList();
			$routelist->add(new Route('test'));
			$routelist->add(new Route('test2'));

			$count = 0;

			foreach($routelist as $routeNumber => $route) {
				$this->assertEquals($count, $routeNumber);
				$count++;
			}

			$this->assertEquals(2, $count);
		}
	}
