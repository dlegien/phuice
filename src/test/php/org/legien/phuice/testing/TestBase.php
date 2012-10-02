<?php

	namespace org\legien\phuice\testing;
	
	use org\legien\phuice\logging\StdOutLogger;

	abstract class TestBase extends \PHPUnit_Framework_Testcase {

		private $loggers;

		public function __construct() {
			$this->loggers = array();
		}
		
		protected function getLogger($name) {
			if(!isset($this->loggers[$name])) {
				$this->loggers[$name] = new StdOutLogger($name);
			}
			return $this->loggers[$name];
		}

	}
