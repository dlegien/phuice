<?php

	namespace org\legien\phuice\pathing;

	class Condition {

		private $_field;
		private $_relation;
		private $_value;
		private $_quoteValue;
		
		public function __construct($field, $relation, $value, $quoteValue = TRUE) {
			$this->setField($field);
			$this->setRelation($relation);
			$this->setValue($value);
			$this->setQuoteValue($quoteValue);			
		}

		private function setQuoteValue($quoteValue) {
			$this->_quoteValue = $quoteValue;
		}

		private function setValue($value) {
			$this->_value = $value;
		}

		private function setRelation($relation) {
			$this->_relation = $relation;
		}

		private function setField($field) {
			$this->_field = $field;
		}
		
		public function __toString() {
			return $this->_quoteValue ? "$this->_field $this->_relation '$this->_value'" : "$this->_field $this->_relation $this->_value";
		}	
	}
