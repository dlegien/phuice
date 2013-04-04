<?php

	namespace org\legien\phuice\installation;
	
	use org\legien\phuice\services\database\PDOService;
	use org\legien\phuice\pathing\Statement;
	
	class PhuiceInstaller extends AbstractInstaller implements InstallerStrategy
	{
		public function __construct(PDOService $service)
		{
			parent::__construct($service, "");
		}
			
		private function patchDatabase($targetPatchLevel)
		{
			$patchlevel = $this->getCurrentPatchLevel();
			
			$this->readPatches('/../../../../../sql/org/legien/phuice/');
			
			
		}
				
		public function invokeInstall($targetPatchLevel = 'latest')
		{
			$this->patchDatabase($targetPatchLevel);
		}
		
		public function invokeUpdate()
		{
			
		}
		
		public function invokeDowngrade()
		{
			
		}
	}
