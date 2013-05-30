<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\generator\components\Dependency;

	class DepedencyTest extends TestBase
	{
		
		public function testConstruction()
		{
			$dependency = new Dependency('dependency');
			
			$this->assertEquals('dependency', $dependency->getName());
			$dependency->setName('dependency2');
			$this->assertEquals('dependency2', $dependency->getName());
			
			$this->assertFalse($dependency->hasAlias());
			$dependency->setAlias('alias');
			$this->assertTrue($dependency->hasAlias());
			$this->assertEquals('alias', $dependency->getAlias());
		}
	}