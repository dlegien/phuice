<?php

	namespace org\legien\phuice\installation;
	
	use org\legien\phuice\services\database\PDOService;
	use org\legien\phuice\pathing\Statement;	
	
	abstract class AbstractInstaller
	{
		private $service;
		private $patchFolder;
		private $upgrade;
		private $targetPatchLevel;
		private $currentPatchLevel;
		
		protected function __construct(PDOService $service, $patchFolder, $targetPatchLevel = 'latest')
		{
			$this->setService($service);
			$this->setPatchFolder($patchFolder);
			$this->setUpgrade(TRUE);
			$this->setTargetPatchLevel($targetPatchLevel);
			$this->setCurrentPatchLevel($this->determineCurrentPatchLevel());
		}
		
		private function setCurrentPatchLevel($currentPatchLevel)
		{
			$this->currentPatchLevel = $currentPatchLevel;
		}
		
		protected function getCurrentPatchLevel()
		{
			return $this->currentPatchLevel;
		}
		
		protected function setTargetPatchLevel($targetPatchLevel)
		{
			$this->targetPatchLevel = $targetPatchLevel;
		}
		
		protected function setUpgrade($upgrade)
		{
			$this->upgrade = $upgrade;
		}
		
		protected function getTargetPatchLevel()
		{
			return $this->targetPatchLevel;
		}
		
		protected function isUpgrade()
		{
			return $this->upgrade;
		}
		
		protected function setPatchFolder($patchFolder)
		{
			$this->patchFolder = $patchFolder;
		}
		
		protected function getPatchFolder()
		{
			return $this->patchFolder;
		}
		
		protected function getService()
		{
			return $this->service;
		}
		
		protected function setService(PDOService $service)
		{
			$this->service = $service;
		}
		
		protected function determineCurrentPatchLevel()
		{
			$stmt = new Statement;
	
			$stmt
				->select('version')
				->from('changelog')
				->orderby('date', 'DESC')
				->limit(0, 1);
			;
			
			$query = $this->getService()->query($stmt)->fetch();
			if($query !== false)
			{
				$version = current($query);
			}
			else 
			{
				$version = "0.0.0.0";
			}
			
			return $version;
		}
		
		private function processPatch($fileinfo)
		{	
			var_dump($fileinfo);
			var_dump($this->getTargetPatchLevel());
		}
		
		protected function readPatches($subfolder)
		{
			$this->currentPatchLevel = $this->getCurrentPatchLevel();
			
			$patchfolder = __DIR__ . $subfolder;
			if($this->isUpgrade())
			{
				$patchfolder .= '/upgrade';
			}
			else
			{
				$patchfolder .= '/downgrade';
			}
			
			foreach (new \FilesystemIterator($patchfolder) as $fileinfo)
			{
			    $this->processPatch($fileinfo);
			}
		}
	}
