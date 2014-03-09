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

	namespace org\legien\phuice\io;
	
	use org\legien\phuice\io\IWriter;

	/**
	 * A writer capable of writing to a file resource.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	io
	 *
	 */
	class FileWriter implements IWriter
	{
		/**
		 * Whether to lock the file exclusively.
		 * 
		 * @var boolean
		 */
		private $_lockExclusively;
		
		/**
		 * Whether to append to the file.
		 * 
		 * @var boolean
		 */
		private $_append;
		
		/**
		 * Constructor.
		 */
		public function __construct()
		{
			$this->setLockExclusively(FALSE);
			$this->setAppend(FALSE);
		}
		
		/**
		 * Sets whether to append to a file.
		 * 
		 * @param boolean $append Whether to append to a file.
		 */
		public function setAppend($append)
		{
			if ($append === TRUE)
			{
				$this->_append = TRUE;
			}
			else 
			{
				$this->_append = FALSE;
			}
		}
		
		/**
		 * Sets whether to lock the file exclusively.
		 * 
		 * @param boolean $lock Whether to lock the file exclusively.
		 */
		public function setLockExclusively($lock)
		{
			if ($lock === TRUE)
			{
				$this->_lockExclusively = TRUE;
			}
			else
			{
				$this->_lockExclusively = FALSE;
			}
		}
		
		/**
		 * Returns whether the file should be locked exclusively.
		 * 
		 * @return boolean
		 */
		private function getLockExclusively()
		{
			return $this->_lockExclusively;
		}
		
		/**
		 * Returns whether to append to the file.
		 * 
		 * @return boolean
		 */
		private function getAppend()
		{
			return $this->_append;
		}
		
		/**
		 * Returns the flags to apply.
		 * 
		 * @return string
		 */
		private function getFlags()
		{
			if($this->getLockExclusively() && $this->getAppend())
			{
				return FILE_APPEND | LOCK_EX;
			}
			elseif($this->getLockExclusively())
			{
				return LOCK_EX;
			}
			elseif($this->getAppend())
			{
				return FILE_APPEND;
			}
			else
			{
				return FALSE;
			}
		}
		
		/**
		 * @see \org\legien\phuice\io\IWriter::createPath()
		 */
		public function createPath($path)
		{
			$packages = explode('/', $path);
			$index = count($packages)-1;
			unset($packages[$index]);
			$folder = getcwd() . DIRECTORY_SEPARATOR;
			foreach($packages as $package)
			{
				$folder .= $package;
				if(!file_exists($folder))
				{
					mkdir($folder);
				}
				$folder .= DIRECTORY_SEPARATOR;
			}
		}

		/**
		 * @see \org\legien\phuice\io\IWriter::write()
		 */
		public function write($resourceName, $content)
		{
			/*if(!file_exists($resourceName))
			{
				throw new FileNotFoundException($resourceName . ' not found.');
			}*/
			
			if(($flags = $this->getFlags()) !== FALSE)
			{
				file_put_contents($resourceName, $content, $flags);
			}
			else
			{
				file_put_contents($resourceName, $content);
			}
		}
	}