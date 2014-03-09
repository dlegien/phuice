<?php

	namespace org\legien\phuice\storages\doctrine;
	
	use org\legien\phuice\storages\AuthenticationStorage;
	use org\legien\phuice\storages\AbstractDoctrineStorage;

	use Doctrine\ORM\EntityManager;
			
	class DoctrineAuthenticationStorage extends AbstractDoctrineStorage implements AuthenticationStorage
	{		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\AuthenticationStorage::findByUsername()
		 */
		public function findByUsername($username)
		{
			return $this->getRepository()->findOneBy(array('username', $username));
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\AuthenticationStorage::findByEmail()
		 */
		public function findByEmail($email)
		{
			return $this->getRepository()->findOneBy(array('email', $email));
		}		
	}