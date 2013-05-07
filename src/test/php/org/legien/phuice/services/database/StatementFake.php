<?php

	namespace org\legien\phuice\services\database;
	
	class StatementFake
	{
		private $return;
		private $service;
		
		public function __construct($service, $return)
		{
			$this->return = $return;
			$this->service = $service;
		}
		
		public function execute($bind)
		{
			$this->service->registerCall('StatementFake', 'execute', array($bind));
		}
		
		public function fetchObject()
		{
			$this->service->registerCall('StatementFake', 'fetchObject', array());
			
			return $this->return;
		}
	}