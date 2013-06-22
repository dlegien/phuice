<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\storages\AbstractAggregateDBStorage;
	use org\legien\phuice\services\database\PDOServiceMock;
	use org\legien\phuice\storages\StorageFilter;
	use org\legien\phuice\mvc\Model;
	use org\legien\phuice\storages\Mapping;
	use org\legien\phuice\storages\KeyRelationList;
	use org\legien\phuice\storages\KeyRelation;
	use org\legien\phuice\services\database\PDOService;
	use org\legien\phuice\pathing\evaluators\SQLStatementEvaluator;
	
	class TestStorage extends AbstractAggregateDBStorage
	{
		public function findById($id)
		{
			return parent::find(array(
					new StorageFilter('id', '=', $id)
			));
		}
		
		protected function getMappings()
		{
			return array(
				new Mapping('super_object', new KeyRelationList(array(new KeyRelation('id', '=', 'id'))), 'SuperObject')		
			);
		}		
	}
	
	class SuperObject implements Model
	{
		protected $id;
		protected $name;
		protected $description;
		
		public function setName($name)
		{
			$this->name = $name;
		}
		
		public function setDescription($description)
		{
			$this->description = $description;
		}
		
		public function toArray()
		{
			return array(
					'id' => $this->id,
					'name' => $this->name,
					'description' => $this->description
			);
		}
	}
	
	class Role extends SuperObject
	{		
		protected $id;
		private $parent_role;
		
		public function setParentRole($parentRole)
		{
			$this->parent_role = $parentRole;
		}
		
		public function toArray()
		{
			$array = array(
				'id' => $this->id,
				'parent_role' => $this->parent_role
			);
			
			return array_merge(parent::toArray(), $array);
		}
	}
	
	class AbstractAggregateDBStorageTest extends TestBase
	{
		public function testConstruction()
		{
/*			
			$connection = new PDOService(new SQLStatementEvaluator(), 'mysql', 'holzmayr', '192.168.178.42', 'holzmayr', 'holzmayr');
			
			$connection = new PDOServiceMock(new Test(1));
			$table = 'role';
			$model = 'Role';
			
			$storage = new TestStorage($connection, $table, $model);

			$role = new Role();
			$role->setName('Name2');
			$role->setDescription('Description2');
			$role->setParentRole(1);
			
			$roleId = $storage->create($role);			
			
			$response = $storage->findAll();
			
			$response = $storage->findById($roleId);

			$response->setName('Name3');
			$storage->update($response);

			$storage->delete($response);
*/
		}	
	}