<?php

	require_once('testloader.php');

	use org\legien\phuice\services\ServiceDirectory;
	use org\legien\phuice\testing\MockObject;

	class ServiceDirectoryTest extends PHPUnit_Framework_Testcase {

		public function setUp() {
			$this->directory = new ServiceDirectory;
		}

		public function testSharedRegistration() {
			$this->assertFalse($this->directory->hasService('shared'));

			$this->directory->register('shared', function($c) {
				return new MockObject();
			}, TRUE);

			$mock = $this->directory->getService('shared');
			$this->assertTrue($this->directory->hasService('shared'));
			
			$mock->setAttribute('test', 'test attribute');
			
			$mock2 = $this->directory->getService('shared');
			$this->assertTrue($mock2->hasAttribute('test'));
			$this->assertEquals('test attribute', $mock2->getAttribute('test'));
		}

		public function testNoneSharedRegistration() {
			$this->assertFalse($this->directory->hasService('notshared'));
			
			$this->directory->register('notshared', function($c) {
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
