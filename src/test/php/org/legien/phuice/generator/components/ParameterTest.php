<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\generator\components\Parameter;

	class ParameterTest extends TestBase
	{
		
		public function testConstruction()
		{
			$parameter = new Parameter('name', 'type', 9, 'description');
			
			$this->assertEquals('name', $parameter->getName());
			$parameter->setName('name2');
			$this->assertEquals('name2', $parameter->getName());
			
			$this->assertEquals('type', $parameter->getType());
			$parameter->setType('type2');
			$this->assertEquals('type2', $parameter->getType());
			
			$this->assertEquals(9, $parameter->getDefaultValue());
			$parameter->setDefaultValue('asd');
			$this->assertEquals('asd', $parameter->getDefaultValue());
			
			$this->assertEquals('description', $parameter->getDescription());
			$parameter->setDescription('description2');
			$this->assertEquals('description2', $parameter->getDescription());
		}
	}