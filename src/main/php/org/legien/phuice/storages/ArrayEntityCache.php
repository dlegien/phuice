<?php

	namespace org\legien\phuice\storages;
	
	use org\legien\phuice\exceptions\InvalidOperationException;
	class ArrayEntityCache implements IEntityCache
	{
		private $cache;

		public function __construct()
		{
			$this->cache = array();
		}
		
		public function add($entity)
		{				
			$entry = new EntityCacheEntry($entity);
			$this->cache[$entry->getGuid()] = $entry;
		}
		
		public function getEntries()
		{
			return $this->cache;
		}
		
		public function remove(EntityCacheEntry $entry)
		{
			$guid = $entry->getGuid();
			if (array_key_exists($guid, $this->cache))
			{
				unset($this->cache[$guid]);
				return;
			}
			
			throw new InvalidOperationException('The entity was not in the cache.');
		}
	}