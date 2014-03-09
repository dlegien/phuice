<?php

	namespace org\legien\phuice\storages;
	
	use Doctrine\ORM\EntityManager;
	
	class DoctrineEntityManagerWrapper implements IDoctrineEntityManagerWrapper
	{
		private $entityManager;
		private $cache;
		
		public function __construct(EntityManager $entityManager, IEntityCache $cache)
		{
			$this->setEntityManager($entityManager);
			$this->setCache($cache);
		}
		
		public function __destruct()
		{
			$manager = $this->getEntityManager();
			$cache = $this->getCache();
			$entries = $cache->getEntries();
			
			foreach ($entries as $entry)
			{
				$manager->flush($entry->getValue());
				$cache->remove($entry);
			}
		}
		
		private function setCache(IEntityCache $cache)
		{
			$this->cache = $cache;
		}
		
		private function getCache()
		{
			return $this->cache;
		}
		
		private function setEntityManager(EntityManager $entityManager)
		{
			$this->entityManager = $entityManager;
		}
		
		private function getEntityManager()
		{
			return $this->entityManager;
		}
		
		public function getRepository($entityName)
		{
			return $this->getEntityManager()->getRepository($entityName);
		}
		
		public function flush()
		{
			$this->getEntityManager()->flush();	
		}
		
		public function persist($entity)
		{
			$return = $this->getEntityManager()->persist($entity);
			$this->getCache()->add($entity);
			return $return;
		}
		
		public function update($entity)
		{
			return $this->getEntityManager()->flush($entity);
		}
		
		public function createTransaction()
		{
			return new DoctrineTransaction($this->getEntityManager()->getConnection());			
		}
		
		public function createQuery($statement)
		{
			return $this->getEntityManager()->createQuery($statement);			
		}
		
		public function remove($entity)
		{
			return $this->getEntityManager()->remove($entity);
		}
		
		public function getConnection()
		{
			return $this->getEntityManager()->getConnection();
		}
	}