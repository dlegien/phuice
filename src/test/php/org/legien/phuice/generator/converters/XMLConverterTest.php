<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\generator\converters\XMLConverter;
	use org\legien\phuice\io\FileReader;
	use org\legien\phuice\io\TestResourceReader;
	
	class XMLConverterTest extends TestBase
	{
		
		public function testConversion()
		{
			$reader = new TestResourceReader('xml/test-classdefinition.xml');
			$xml = $reader->read();
			
			$converter = new XMLConverter();
			$classes = $converter->convert($xml);
			
			$this->assertCount(1, $classes);
			/**
			 * @var $class ClassDefinition
			 */
			$class = $classes[0];
			
			$this->assertEquals('ClassDefinition', $class->getName());
			$this->assertFalse($class->getAbstract());
			$this->assertEquals('Daniel Legien', $class->getAuthor());
			$this->assertEquals('The ClassDefinition class.', $class->getDescription());
			
			$fields = $class->getFields();
			$privateFields = $fields['private'];
			
			$this->assertCount(11, $privateFields);
		}
	}