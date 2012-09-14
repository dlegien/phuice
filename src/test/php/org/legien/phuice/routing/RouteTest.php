<?php

	require_once('testloader.php');

	use org\legien\phuice\routing\Route;

	class RouteTest extends PHPUnit_Framework_TestCase {

		public function testSimpleRouteMatching() {

			$route = new Route(':controller/:action/:id', array(), array());
			$route->matchWith('class/method/1');
			$this->assertTrue($route->isMatched()); 

		}
	}
