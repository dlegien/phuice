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

	use org\legien\phuice\routing\RouteList;
	use org\legien\phuice\routing\Route;
	use org\legien\phuice\testing\TestBase;

	/**
	 * Testcases for RouteLists.
	 * 
	 * @author		Daniel Legien
	 *
	 */
	class RouteListTest extends TestBase 
	{
		/**
		 * Tests the construction of a simple RouteList.
		 */
		public function testSimpleRouteListCreation() 
		{
			$routelist = new RouteList();
			$routelist->add(new Route('test'));
			$routelist->add(new Route('test2'));

			$count = 0;
			foreach($routelist as $routeNumber => $route) 
			{
				$this->assertEquals($count, $routeNumber);
				$count++;
			}

			$this->assertEquals(2, $count);
		}
	}
