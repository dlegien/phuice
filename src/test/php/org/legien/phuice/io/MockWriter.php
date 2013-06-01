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
	
	/**
	 * A writer for testing purposes that stores information
	 * about the created paths and written files in arrays
	 * for later retrieval.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	io
	 *
	 */
	class MockWriter implements IWriter
	{
		/**
		 * The paths that were created using the writer.
		 * 
		 * @var array
		 */
		private $_paths;
		
		/**
		 * The files that were written using the writer.
		 * 
		 * @var array
		 */
		private $_files;
		
		/**
		 * Constructor.
		 */
		public function __construct()
		{
			$this->_paths = array();
			$this->_files = array();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\io\IWriter::createPath()
		 */
		public function createPath($path)
		{
			$this->_paths[] = $path;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\io\IWriter::write()
		 */
		public function write($resourceName, $content)
		{
			$this->_files[] = array($resourceName, $content);
		}
		
		/**
		 * Returns the recorded paths.
		 * 
		 * @return array
		 */
		public function getPaths()
		{
			return $this->_paths;
		}
		
		/**
		 * Returns the recorded files.
		 * 
		 * @return array
		 */
		public function getFiles()
		{
			return $this->_files;	
		}
	}