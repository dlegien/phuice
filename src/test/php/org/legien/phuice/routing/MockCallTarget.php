<?php

	namespace org\legien\phuice\routing;

	class MockCallTarget {

		private $gotCalled;

		public function __construct() {
			$this->gotCalled = FALSE;
		}

		public function call($id) {
			if($id == 2) {
				$this->gotCalled = TRUE;
			}
		}

		public function gotCalled() {
			return $this->gotCalled;
		}
	}
