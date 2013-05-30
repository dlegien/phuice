<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\generator\components\ClassDefinition;
	use org\legien\phuice\generator\components\Field;
	use org\legien\phuice\generator\components\Method;
use org\legien\phuice\generator\components\Dependency;

	class ClassDefinitionTest extends TestBase
	{
		
		public function testConstruction()
		{
			$class = new ClassDefinition('name', 'namespace');
			
			$this->assertEquals('name', $class->getName());
			$class->setName('name2');
			$this->assertEquals('name2', $class->getName());
			
			$this->assertEquals('namespace', $class->getNamespace());
			$class->setNamespace('namespace2');
			$this->assertEquals('namespace2', $class->getNamespace());
			
			$this->assertEquals('namespace2\\name2', $class->getFullQualifiedName());
			
			$class->setNamespace('');
			$this->assertEquals('name2', $class->getFullQualifiedName());
			
			$class->setDescription('Description');
			$this->assertEquals('Description', $class->getDescription());
			
			$this->assertCount(0, $class->getImplements());
			$class->setImplements('interface');
			$this->assertCount(1, $class->getImplements());
			$this->assertEquals(array('interface'), $class->getImplements());
			
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
			
			$this->assertFalse($class->hasSetter('field'));
			$class->setSetter('field');
			$this->assertTrue($class->hasSetter('field'));
			
			$this->assertFalse($class->hasGetter('field'));
			$class->setGetter('field');
			$this->assertTrue($class->hasGetter('field'));
			
			$this->assertCount(0, $class->getMethods());
			$class->setMethod(new Method('test'));
			$this->assertCount(1, $class->getMethods());
			
			$this->assertCount(0, $class->getDependencies());
			$class->setDependency(new Dependency('dependency'));
			$this->assertCount(1, $class->getDependencies());
		}
	}