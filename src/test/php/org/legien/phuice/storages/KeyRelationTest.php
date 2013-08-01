<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\storages\KeyRelation;

	/**
	 * Testcases for key relations.
	 * 
	 * @author Daniel Legien
	 *
	 */
	class KeyRelationTest extends TestBase
	{
		/**
		 * Tests whether key relations can be constructed.
		 */
		public function testConstruction()
		{
			// Preparation
			$sourceKey = 'key1';
			$relation = '>=';
			$destinationKey = 'key2';
			
			// Test
			$keyRelation = new KeyRelation($sourceKey, $relation, $destinationKey);
			
			// Assertions
			$this->assertEquals('key1', $keyRelation->getSourceKey());
			$this->assertEquals('>=', $keyRelation->getRelation());
			$this->assertEquals('key2', $keyRelation->getDestinationKey());
		}
	}