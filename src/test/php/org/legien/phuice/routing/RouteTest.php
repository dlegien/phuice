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

	use org\legien\phuice\routing\Route;
	use org\legien\phuice\routing\RouteException;
	use org\legien\phuice\testing\TestBase;

	/**
	 * Test cases for routes.
	 * 
	 * @author Daniel Legien
	 *
	 */
	class RouteTest extends TestBase 
	{
		/**
		 * Tests if a simple route with two variables can be matched.
		 */
		public function testSimpleRouteMatching() 
		{
			$route = new Route(':controller/:action/:id', array(), array());
			$route->matchWith('class/method/1');
			$this->assertTrue($route->isMatched()); 
		}
		
		/**
		 * Tests the matching of a complex route.
		 */
		public function testComplexRouteMatching() 
		{		
			$route = new Route('settings/?:ref', array(), array());
			$route->matchWith('settings/?msg');
			$this->assertTrue($route->isMatched());
		}
		
		/**
		 * Tests if routes with a wildcard are matched properly.
		 */
		public function testMatchWith()
		{
			$route = new Route('test/*', array(), array());
			$route->matchWith('test/abc');
			$this->assertTrue($route->isMatched());
		}
		
		/**
		 * Tests if retrieving a not set parameter returns NULL.
		 */
		public function testGetNotSetParameter()
		{
			$route = new Route('test/');
			$this->assertNull($route->getParameter('blubb'));
		}
		
		/**
		 * Tests whether retrieving parameters from an unmatched and unprocessed
		 * route throws the expected exception.
		 * 
		 * @expectedException org\legien\phuice\routing\RouteException
		 */		
		public function testGetParametersFromUnprocessedAndUnmatchedRoute()
		{
			$route = new Route('test/');
			$route->getParameters();
		}

		/**
		 * Tests if parameters are set properly if set with an equality sign.
		 */
		public function testParametersWithEquality()
		{
			$route = new Route('test/:bla');
			$route->matchWith('test/abc=def');
			$parameters = $route->getParameters();
			
			$this->assertEquals('def', $parameters['abc']);
		}
		
		/**
		 * Tests the integration of targets into the parameters.
		 */
		public function testTargets()
		{
			$route = new Route('test/', array('bla' => 'blubb'));
			$route->matchWith('test/');
			
			$parameters = $route->getParameters();
			$this->assertEquals('blubb', $parameters['bla']);
		}
	}