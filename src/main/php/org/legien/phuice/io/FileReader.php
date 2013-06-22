<?php

	namespace org\legien\phuice\io;
	
	/**
	 * A reader implementation for the purpose of reading from
	 * files.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	io
	 *
	 */
	class FileReader extends AbstractReader
	{
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\io\AbstractReader::readResource()
		 */
		protected function readResource()
		{
			return file_get_contents($this->getResourceName());
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\io\AbstractReader::resourceExists()
		 */
		protected function resourceExists()
		{
			return file_exists($this->getResourceName());
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\io\AbstractReader::throwResourceNotFoundException()
		 */
		protected function throwResourceNotFoundException()
		{
			throw new FileNotFoundException($this->getResourceName());
		}
	}