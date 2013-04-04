<?php
	namespace org\legien\phuice\storages\database;

	use org\legien\phuice\storages\AuthenticationStorage;
	use org\legien\phuice\storages\AbstractDBStorage;
	use org\legien\phuice\services\database\PDOService;
	use org\legien\phuice\storages\StorageFilter;

	class DBAuthenticationStorage extends AbstractDBStorage implements AuthenticationStorage 
	{
		public function findByUsername($username) 
		{
			return parent::find(array(
				new StorageFilter('username', '=', $username)
			));
		}
		
		public function findByEmail($email)
		{
			return parent::find(array(
				new StorageFilter('email', '=', $email)
			));
		}
	}
