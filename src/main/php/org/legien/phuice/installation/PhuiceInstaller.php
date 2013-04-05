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
	 * The installer for the phuice framework.
	 */
	class PhuiceInstaller extends AbstractInstaller implements InstallerStrategy
	{
		/**
		 * Creates a new instance.
		 * 
		 * @param	PDOService	$service	The database service.
		 */
		public function __construct(PDOService $service)
		{
			parent::__construct($service, __DIR__ . '/../../../../../sql/');
		}

		/**
		 * Patches the database to the given target patch level.
		 * 
		 * @param	string	$targetPatchLevel	The target patch level.
		 */
		private function patchDatabase($targetPatchLevel)
		{
			$patchlevel = $this->getCurrentPatchLevel();			
			$this->readPatches('org/legien/phuice/');
		}
				
		/**
		 * Performs an installation. If no patch level is specified the
		 * latest patch will be applied.
		 * 
		 * @param	string	$targetPatchLevel	The target patch level.
		 */
		public function invokeInstall($targetPatchLevel = 'latest')
		{
			$this->setUpgrade(TRUE);			
			$this->patchDatabase($targetPatchLevel);
		}
		
		/**
		 * Performs an update. If no patch level is specified the latest
		 * patch will be applied.
		 * 
		 * @param	string	$targetPatchLevel	The target patch level.
		 */
		public function invokeUpgrade($targetPatchLevel = 'latest')
		{
			$this->setUpgrade(TRUE);
			$this->patchDatabase($targetPatchLevel);
		}
		
		/**
		 * Performs a downgrade. If no patch level is specified the
		 * predecessor of the current patch level is applied.
		 * 
		 * @param	string	$targetPatchLevel	The target patch level.
		 */
		public function invokeDowngrade($targetPatchLevel = 'predecessor')
		{
			$this->setUpgrade(FALSE);
			$this->patchDatabase($targetPatchLevel);
		}
	}
