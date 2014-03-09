<?php

	namespace org\legien\phuice\storages;
	
	use org\legien\phuice\GuidGenerator;
	
	/**
	 * An entry of an entity cache.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	class EntityCacheEntry
	{
		private $guid;
		private $value;
		
		/**
		 * Constructor.
		 * 
		 * @param string $guid The guid that identifies the entry.
		 * @param mixed $value The value of the entry.
		 */
		public function __construct($value)
		{
			$this->setGuid(GuidGenerator::createGuid());
			$this->setValue($value);
		}
		
		/**
		 * Sets the guid of the entry.
		 * 
		 * @param string $guid The guid of the entry.
		 */
		private function setGuid($guid)
		{
			$this->guid = $guid;
		}
		
		/**
		 * Returns the entry's guid.
		 * 
		 * @return string
		 */
		public function getGuid()
		{
			return $this->guid;
		}
		
		/**
		 * Sets the entry's value.
		 * 
		 * @param mixed $value The entry's value.
		 */
		private function setValue($value)
		{
			$this->value = $value;
		}
		
		/**
		 * Returns the entry's value.
		 * 
		 * @return mixed
		 */
		public function getValue()
		{
			return $this->value;
		}
	}