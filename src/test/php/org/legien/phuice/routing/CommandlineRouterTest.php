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

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\routing\CommandlineRouter;
	use org\legien\phuice\routing\Route;
	use org\legien\phuice\services\ServiceDirectory;
	use org\legien\phuice\routing\MockCallTarget;

	/**
	 * Test cases for the CommandlineRouter.
	 * 
	 * @author Daniel Legien
	 *
	 */
	class CommandlineRouterTest extends TestBase
	{
		/**
		 * (non-PHPdoc)
		 * @see PHPUnit_Framework_TestCase::setUp()
		 */
		public function setUp()
		{
			$this->serviceDirectory = new ServiceDirectory();
			$this->serviceDirectory->register('mock', new MockCallTarget());
		}		
		
		/**
		 * Tests the routing from commandline parameters.
		 */
		public function testRouting()
		{
			$router = new CommandlineRouter($this->serviceDirectory);
			$router->addRoute(new Route(':controller/:method/:id'));
			
			$router->route(array('mock', 'call', '2'));
			
			$this->assertTrue($this->serviceDirectory->getService('mock')->gotCalled());
		}
	}