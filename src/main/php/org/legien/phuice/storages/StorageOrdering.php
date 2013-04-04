<?php

	namespace org\legien\phuice\storages;
	
	class StorageOrdering
	{
		private $_field;
		private $_direction;
		
		public function __construct($field, $direction)
		{
			$this->setField($field);
			$this->setDirection($direction);
		}
		
		private function setField($field)
		{
			$this->_field = $field;
		}
		
		public function getField()
		{
			return $this->_field;
		}
		
		private function setDirection($direction)
		{
			$this->_direction = $direction;
		}
		
		public function getDirection()
		{
			return $this->_direction;
		}
	}
