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

	namespace org\legien\phuice\packaging;

	/**
	 * A helper class for packaging the application source into a phar file.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	packaging
	 *
	 */
	class Packager 
	{
		/**
		 * The name of the phar file.
		 * 
		 * @var string
		 */
		private $pharName;
		
		/**
		 * The path the phar file will be created in.
		 * 
		 * @var string
		 */
		private $buildPath;
		
		/**
		 * The path where the source should be taken from.
		 * 
		 * @var string
		 */
		private $srcPath;
		
		/**
		 * The path to the stub file.
		 * 
		 * @var string
		 */
		private $stubPath;

		/**
		 * Creates a new Packager.
		 *  
		 * @param string	$pharName	The name of the phar file.
		 * @param string	$buildPath	The path where the phar is build.
		 * @param string	$srcPath	The path to the sources.
		 */
		public function __construct($pharName, $buildPath, $srcPath) 
		{
			$this->setPharName($pharName);
			$this->setBuildPath($buildPath);
			$this->setSrcPath($srcPath);
		}
		
		/**
		 * Sets the path of the sources.
		 * 
		 * @param string $srcPath	The path to the sources.
		 */
		private function setSrcPath($srcPath)
		{
			$this->srcPath = $srcPath;
		}
		
		/**
		 * Sets the path where the phar file will be build.
		 * 
		 * @param string $buildPath The path where the phar will be build.
		 */
		private function setBuildPath($buildPath)
		{
			$this->buildPath = $buildPath;
		}

		/**
		 * Sets the name of the phar file.
		 * 
		 * @param string $pharName	The name of the phar file.
		 */
		private function setPharName($pharName) 
		{
			$this->pharName = $pharName;
		}

		/**
		 * Returns the name of the phar file and appends .phar
		 * to it.
		 * 
		 * @return string
		 */
		public function getPharName() 
		{
			return $this->pharName.'.phar';
		}

		/**
		 * Sets the path to the default stub.
		 * 
		 * @param string $stubPath The path to the stub.
		 */
		public function setDefaultStub($stubPath) 
		{
			$this->stubPath = $stubPath;
		}

		/**
		 * Returns the path to the stub file.
		 * 
		 * @return string
		 */
		private function getStub() 
		{
			return $this->stubPath;
		}

		/**
		 * Returns the source path.
		 * 
		 * @return string
		 */
		private function getSrcPath() 
		{
			return $this->srcPath;
		}

		/**
		 * Returns the build path.
		 * @return string
		 */
		private function getBuildPath() 
		{
			return $this->buildPath;
		}

		/**
		 * Returns the filename that is combined out of the build path
		 * and name of the phar file.
		 * 
		 * @return string
		 */
		private function getFileName() 
		{
			return $this->getBuildPath().$this->getPharName();
		}

		/**
		 * Packages the source and writes the phar file.
		 * 
		 */
		public function package() 
		{
			$phar = new \Phar($this->getFileName(), 0, $this->getPharName());				
			$phar->buildFromIterator(
				new \RecursiveIteratorIterator(
						new \RecursiveDirectoryIterator($this->getSrcPath(), \FilesystemIterator::SKIP_DOTS)
				)					
				, $this->getSrcPath()
			);
			$phar->setStub($phar->createDefaultStub($this->getStub()));
		}

	}
