<?php

	namespace org\legien\phuice\services\doctrine;
	
	use org\legien\phuice\services\database\ITransaction;
	use Doctrine\ORM\EntityManager;
	use Doctrine\DBAL\Connection;
			
	class DoctrineTransaction implements ITransaction
	{
		/**
		 * The Doctrine Connection.
		 * 
		 * @var Connection
		 */
		private $_connection;
		
		/**
		 * Creates a new transaction object for the given connection object.
		 *
		 * @param \PDO $connection The connection object.
		 */
		public function __construct(Connection $connection)
		{
			$this->setConnection($connection);
		}
		
		/**
		 * Sets the Doctrine Connection. 
		 * 
		 * @param Connection $connection The Doctrine Connection.
		 */
		private function setConnection(Connection $connection)
		{
			$this->_connection = $connection;
		}
		
		/**
		 * Returns the Doctrine Connection.
		 * 
		 * @return \Doctrine\DBAL\Connection
		 */
		private function getConnection()
		{
			return $this->_connection;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\services\database\ITransaction::start()
		 */
		public function start()
		{
			$this->getConnection()->beginTransaction();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\services\database\ITransaction::commit()
		 */
		public function commit()
		{
			$this->getConnection()->commit();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\services\database\ITransaction::rollback()
		 */
		public function rollback()
		{
			$this->getConnection()->rollback();
		}
	}