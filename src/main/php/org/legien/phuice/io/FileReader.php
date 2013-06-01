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
		protected function readResource()
		{
			return file_get_contents($this->getResourceName());
		}
		
		protected function resourceExists()
		{
			return file_exists($this->getResourceName());
		}
		
		protected function throwResourceNotFoundException()
		{
			throw new FileNotFoundException($this->getResourceName());
		}
	}