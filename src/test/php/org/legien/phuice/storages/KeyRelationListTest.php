<?php

	use org\legien\phuice\testing\TestBase;
use org\legien\phuice\storages\KeyRelationList;
use org\legien\phuice\storages\KeyRelation;

	class KeyRelationListTest extends TestBase
	{
		public function testConstruction()
		{
			$relationList = new KeyRelationList();			
			$this->assertCount(0, $relationList);
		}
		
		public function testAddition()
		{
			$relationList = new KeyRelationList();			
			$this->assertCount(0, $relationList);
			
			$relationList->add(new KeyRelation('key1', '<=', 'key2'));
			
			$this->assertCount(1, $relationList);
			
			foreach ($relationList as $relation)
			{
				$this->assertEquals('key1', $relation->getSourceKey());
				$this->assertEquals('<=', $relation->getRelation());
				$this->assertEquals('key2', $relation->getDestinationKey());
			}
			
		}
	}