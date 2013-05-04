<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 * 
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 * 
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	namespace org\legien\phuice\installation;
	
	use org\legien\phuice\services\database\PDOService;
	use org\legien\phuice\pathing\Statement;	
	
	/**
	 * Bundles useful methods for installers.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	installation
	 */
	abstract class AbstractInstaller
	{
		/**
		 * The database connection.
		 * 
		 * @var PDOService
		 */
		private $service;
		
		/**
		 * The folder containing the database patches.
		 * 
		 * @var string
		 */
		private $patchFolder;
		
		/**
		 * Whether an upgrade or downgrade will be performed.
		 * 
		 * @var boolean
		 */
		private $upgrade;
		
		/**
		 * The target patch level.
		 * 
		 * @var	string
		 */
		private $targetPatchLevel;
		
		/**
		 * The current patch level.
		 * 
		 * @var string
		 */
		private $currentPatchLevel;
		
		/**
		 * Initializes the AbstractInstaller.
		 * 
		 * @param	PDOService	$service		The database connection.
		 * @param	string		$patchFolder	The location of the patches.
		 */
		protected function __construct(PDOService $service, $patchFolder)
		{
			$this->setService($service);
			$this->setPatchFolder($patchFolder);
			$this->setCurrentPatchLevel($this->determineCurrentPatchLevel());
		}
		
		/**
		 * Sets the current patch level.
		 * 
		 * @param	string	$currentPatchLevel	The current patch level.
		 */
		private function setCurrentPatchLevel($currentPatchLevel)
		{
			$this->currentPatchLevel = $currentPatchLevel;
		}
		
		/**
		 * Returns the current patch level.
		 * 
		 * @return	string
		 */
		protected function getCurrentPatchLevel()
		{
			return $this->currentPatchLevel;
		}
		
		/**
		 * Sets the target patch level.
		 * 
		 * @param	string	$targetPatchLevel	The target patch level.
		 */
		protected function setTargetPatchLevel($targetPatchLevel)
		{
			$this->targetPatchLevel = $targetPatchLevel;
		}
		
		/**
		 * Sets whether to perform an upgrade or a downgrade.
		 * 
		 * @param	boolean	$upgrade	Whether to perform an upgrade.
		 */
		protected function setUpgrade($upgrade)
		{
			$this->upgrade = $upgrade;
		}
		
		/**
		 * Returns the target patch level.
		 * 
		 * @return	string
		 */
		protected function getTargetPatchLevel()
		{
			return $this->targetPatchLevel;
		}
		
		/**
		 * Returns whether the installer was configured to perform
		 * an upgrade.
		 * 
		 * @return	boolean
		 */
		protected function isUpgrade()
		{
			return $this->upgrade;
		}
		
		/**
		 * Sets the patch file folder.
		 * 
		 * @param	string	$patchFolder	The patch file folder.
		 */
		protected function setPatchFolder($patchFolder)
		{
			$this->patchFolder = $patchFolder;
		}
		
		/**
		 * Returns the patch file folder.
		 * 
		 * @return	string
		 */
		protected function getPatchFolder()
		{
			return $this->patchFolder;
		}
		
		/**
		 * Returns the database service.
		 * 
		 * @return	PDOService
		 */
		protected function getService()
		{
			return $this->service;
		}
		
		/**
		 * Sets the database service.
		 * 
		 * @param	PDOService	$service	The database service.
		 */
		protected function setService(PDOService $service)
		{
			$this->service = $service;
		}
		
		/**
		 * Determines the current patch level.
		 * 
		 * @return	string
		 */
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
		
		/**
		 * Processes a patch.
		 * 
		 * @param	mixed	$fileinfo	The file information.
		 */
		private function processPatch($fileinfo)
		{	
			var_dump($fileinfo);
			var_dump($this->getTargetPatchLevel());
		}
		
		/**
		 * Reads patches from the given subfolder.
		 * 
		 * @param	string	$subfolder	The subfolder.
		 */
		protected function readPatches($subfolder)
		{
			$this->currentPatchLevel = $this->getCurrentPatchLevel();
			
			$patchfolder = $this->getPatchFolder() . $subfolder;
			if($this->isUpgrade())
			{
				$patchfolder .= 'upgrade/';
			}
			else
			{
				$patchfolder .= 'downgrade/';
			}
			
			foreach (new \FilesystemIterator($patchfolder) as $fileinfo)
			{
			    $this->processPatch($fileinfo);
			}
		}
	}
