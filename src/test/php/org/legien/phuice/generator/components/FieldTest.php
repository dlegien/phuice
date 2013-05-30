<?php

	use org\legien\phuice\testing\TestBase;
use org\legien\phuice\generator\components\Field;

	class FieldTest extends TestBase
	{
		
		public function testConstruction()
		{
			
			$field = new Field('name', 'type', 'description', 'public', 2);
			
			$this->assertEquals('name', $field->getName());
			$field->setName('name2');
			$this->assertEquals('name2', $field->getName());
			
			$this->assertEquals('public', $field->getVisibility());
			$field->setVisibility('private');
			$this->assertEquals('private', $field->getVisibility());
			
			$this->assertEquals('type', $field->getType());
			$field->setType('type2');
			$this->assertEquals('type2', $field->getType());
			
			$this->assertEquals('description', $field->getDescription());
			$field->setDescription('description2');
			$this->assertEquals('description2', $field->getDescription());
			
			$this->assertEquals(' = 2', $field->getDefaultValue());
			$field->setDefaultValue('a0512');
			$this->assertEquals(" = 'a0512'", $field->getDefaultValue());
		}
	}