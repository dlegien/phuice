<?php

	namespace org\legien\phuice\installation;
	
	class Installer
	{
		private $strategy;
		
		public function __construct(InstallerStrategy $strategy)
		{
			$this->setStrategy($strategy);
		}
		
		private function setStrategy(InstallerStrategy $strategy)
		{
			$this->strategy = $strategy;
		}
		
		private function getStrategy()
		{
			return $this->strategy;
		}
		
		public function install()
		{
			$this->getStrategy()->invokeInstall();
		}
		
		public function update()
		{
			$this->getStrategy()->invokeUpgrade();
		}
		
		public function downgrade()
		{
			$this->getStrategy()->invokeDowngrade();
		}				
	}
