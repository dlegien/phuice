<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	use org\legien\phuice\routing\DefaultRouter;
	use org\legien\phuice\routing\MockCallTarget;
	use org\legien\phuice\routing\Route;
	use org\legien\phuice\routing\RouteList;
	use org\legien\phuice\services\ServiceDirectory;
	use org\legien\phuice\testing\TestBase;

	/**
	 * Test cases for the DefaultRouter.
	 * 
	 * @author Daniel Legien
	 *
	 */
	class DefaultRouterTest extends TestBase 
	{
		/**
		 * (non-PHPdoc)
		 * @see PHPUnit_Framework_TestCase::setUp()
		 */
		public function setUp() 
		{
			$this->serviceDirectory = new ServiceDirectory;
			$this->serviceDirectory->register('mock', new MockCallTarget());
		}

		/**
		 * Tests a successful service call.
		 */
		public function testSuccessfulServiceCall() 
		{
			$router = new DefaultRouter($this->serviceDirectory);
			$router->addRoute(new Route(':controller/:method/:id'));

			$router->route('mock/call/2');

			$this->assertTrue($this->serviceDirectory->getService('mock')->gotCalled());
		}
		
		/**
		 * Tests if a list of routes can be added to the router.
		 */
		public function testAddingListOfRoutes() 
		{	
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