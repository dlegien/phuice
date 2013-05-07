<?php

	namespace org\legien\phuice\testing;
	
	abstract class AbstractMock
	{
		private $calls = array();
				
		public function registerCall($class, $method, $arguments)
		{
			$this->calls[] = array($class, $method, $arguments);
		}
		
		public function getCalls()
		{
			return $this->calls;
		}
	}