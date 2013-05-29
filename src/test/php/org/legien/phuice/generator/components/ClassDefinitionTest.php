<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\generator\components\ClassDefinition;
use org\legien\phuice\generator\components\Field;

	class ClassDefinitionTest extends TestBase
	{
		
		public function testConstruction()
		{
			$class = new ClassDefinition('name', 'namespace');
			
			$this->assertEquals('name', $class->getName());
			$this->assertEquals('namespace', $class->getNamespace());
			
			$class->setAbstract(true);
			$this->assertTrue($class->getAbstract());
			$class->setAbstract(false);
			$this->assertFalse($class->getAbstract());
			
			$class->setAuthor('author');
			$this->assertEquals('author', $class->getAuthor());
			
			$class->setExtends('baseclass');
			$this->assertEquals(array('baseclass'), $class->getExtends());
			
			$field = new Field('field', 'type');
			$class->setField($field);
			$this->assertEquals(array('private' => array($field)), $class->getFields());
		}
	}