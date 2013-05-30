<?php

	use org\legien\phuice\testing\TestBase;
use org\legien\phuice\generator\components\Method;
use org\legien\phuice\generator\components\Parameter;
	
	class MethodTest extends TestBase
	{
		
		public function testConstruction()
		{
			$method = new Method('name', array(), 'returntype', 'asd', 'description', 'protected');
			
			$this->assertEquals('name', $method->getName());
			$method->setName('name2');
			$this->assertEquals('name2', $method->getName());
			
			$this->assertCount(0, $method->getParameters());
			$parameters = array(new Parameter('parameter', 'type'));
			$method->setParameters($parameters);
			$this->assertCount(1, $method->getParameters());
			
			$this->assertEquals('returntype', $method->getReturnType());
			$method->setReturnType('returntype2');
			$this->assertEquals('returntype2', $method->getReturnType());
			
			$this->assertEquals('asd', $method->getBody());
			$method->setBody('qwe');
			$this->assertEquals('qwe', $method->getBody());
			
			$this->assertEquals('description', $method->getDescription());
			$method->setDescription('description2');
			$this->assertEquals('description2', $method->getDescription());
			
			$this->assertEquals('protected', $method->getVisibility());
			$method->setVisibility('private');
			$this->assertEquals('private', $method->getVisibility());
		}
	}