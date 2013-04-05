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
	
	/**
	 * Performs an installation, upgrade or downgrade using the given 
	 * InstallationStrategy.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	installation
	 */
	class Installer
	{
		/**
		 * @var InstallerStrategy
		 */
		private $strategy;
		
		/**
		 * Creates a new instance of the Installer.
		 * 
		 * @param	InstallerStrategy	$strategy	The strategy to use.
		 */
		public function __construct(InstallerStrategy $strategy)
		{
			$this->setStrategy($strategy);
		}
		
		/**
		 * Sets the strategy used for the installation.
		 * 
		 * @param	InstallerStrategy	$strategy	The strategy to use.
		 */
		private function setStrategy(InstallerStrategy $strategy)
		{
			$this->strategy = $strategy;
		}
		
		/**
		 * Returns the strategy used for the installation.
		 * 
		 * @return	InstallerStrategy
		 */
		private function getStrategy()
		{
			return $this->strategy;
		}
		
		/**
		 * Performs the installation.
		 */
		public function install()
		{
			$this->getStrategy()->invokeInstall();
		}
		
		/**
		 * Performs an upgrade.
		 */
		public function upgrade()
		{
			$this->getStrategy()->invokeUpgrade();
		}
		
		/**
		 * Performs a downgrade
		 */
		public function downgrade()
		{
			$this->getStrategy()->invokeDowngrade();
		}				
	}
