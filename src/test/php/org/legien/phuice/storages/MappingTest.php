<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\storages\Mapping;
	use org\legien\phuice\storages\KeyRelationList;
	use org\legien\phuice\storages\KeyRelation;

	/**
	 * Testcases for mappings.
	 * 
	 * @author Daniel Legien
	 *
	 */
	class MappingTest extends TestBase
	{
		/**
		 * Tests whether a mapping can be constructed.
		 */
		public function testConstruction()
		{
			// Preparation
			$keyRelations = new KeyRelationList();
			$keyRelations->add(new KeyRelation('key1', '=', 'key2'));
			
			$sourceTable = 'table';			
			$sourceModel = 'model';
			
			// Test
			$mapping = new Mapping($sourceTable, $keyRelations, $sourceModel);
			
			// Assertions
			$this->assertEquals('table', $mapping->getSourceTable());
			$this->assertEquals('model', $mapping->getSourceModel());
			$this->assertCount(1, $mapping->getKeyRelations());
			
			$relations = $mapping->getKeyRelations();
			$relations->rewind();
			
			$relation = $relations->current();
			
			$this->assertEquals('key1', $relation->getSourceKey());
			$this->assertEquals('=', $relation->getRelation());
			$this->assertEquals('key2', $relation->getDestinationKey());
		}		
	}