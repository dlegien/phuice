<?php

	namespace org\legien\phuice\testing;

	class MockObject {

		private $attributes;

		public function __construct() {
			$this->attributes = array();
		}

		public function setAttribute($name, $value) {
			$this->attributes[$name] = $value;
		}

		public function getAttribute($name) {
			return $this->attributes[$name];
		}

		public function hasAttribute($name) {
			return isset($this->attributes[$name]);
		}
	}
