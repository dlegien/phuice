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

	use org\legien\phuice\services\ServiceDirectory;
	use org\legien\phuice\testing\MockObject;
	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\logging\StdOutLogger;

	/**
	 * Testcases for the ServiceDirectory.
	 * 
	 * @author Daniel Legien
	 *
	 */
	class ServiceDirectoryTest extends TestBase 
	{
		/**
		 * (non-PHPdoc)
		 * @see PHPUnit_Framework_TestCase::setUp()
		 */
		public function setUp() 
		{
			$this->directory = new ServiceDirectory;
		}

		/**
		 * Tests the registration of a shared service.
		 */
		public function testSharedRegistration() 
		{
			$this->assertFalse($this->directory->hasService('shared'));

			$this->directory->register('shared', function($c) 
			{
				return new MockObject();
			}, TRUE);

			$mock = $this->directory->getService('shared');
			$this->assertTrue($this->directory->hasService('shared'));
			
			$mock->setAttribute('test', 'test attribute');
			
			$mock2 = $this->directory->getService('shared');
			$this->assertTrue($mock2->hasAttribute('test'));
			$this->assertEquals('test attribute', $mock2->getAttribute('test'));
		}

		/**
		 * Tests the registration of a not-shared service.
		 */
		public function testNoneSharedRegistration() 
		{
			$this->assertFalse($this->directory->hasService('notshared'));
			
			$this->directory->register('notshared', function($c) 
			{
				return new MockObject();
			});

			$this->assertTrue($this->directory->hasService('notshared'));
			$mock = $this->directory->getService('notshared');

			$this->assertFalse($mock->hasAttribute('test'));
			$mock->setAttribute('test', 'test attribute');
			$this->assertTrue($mock->hasAttribute('test'));
			$this->assertEquals('test attribute', $mock->getAttribute('test'));

			$mock2 = $this->directory->getService('notshared');
			$this->assertFalse($mock2->hasAttribute('test'));
		}
	}