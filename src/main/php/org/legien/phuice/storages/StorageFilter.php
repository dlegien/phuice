<?php
	namespace org\legien\phuice\storages;

	class StorageFilter {
	
		private $_field;
		private $_relation;
		private $_value;
		
	
		public function __construct($field, $relation, $value) {
			$this->setField($field);
			$this->setRelation($relation);
			$this->setValue($value);
		}
		
		private function setField($field) {
			$this->_field = $field;
		}

		private function setRelation($relation) {
			$this->_relation = $relation;
		}

		private function setValue($value) {
			$this->_value = $value;
		}

		public function getField() {
			return $this->_field;
		}
		
		public function getRelation() {
			return $this->_relation;
		}
		
		public function getValue() {
			return $this->_value;
		}
	}

