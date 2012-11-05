<?php

	namespace org\legien\phuice\testing;

	class MockObject {

		private $_attributes;

		public function __construct() {
			$this->_attributes = array();
		}

		public function setAttribute($name, $value) {
			$this->_attributes[$name] = $value;
		}

		public function getAttribute($name) {
			return $this->_attributes[$name];
		}

		public function hasAttribute($name) {
			return isset($this->_attributes[$name]);
		}
	}
