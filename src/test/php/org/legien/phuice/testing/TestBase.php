<?php

	namespace org\legien\phuice\testing;
	
	use org\legien\phuice\logging\StdOutLogger;

	abstract class TestBase extends \PHPUnit_Framework_Testcase {

		private $_loggers;

		public function __construct() {
			$this->_loggers = array();
		}
		
		protected function getLogger($name) {
			if(!isset($this->_loggers[$name])) {
				$this->_loggers[$name] = new StdOutLogger($name);
			}
			return $this->_loggers[$name];
		}

	}
