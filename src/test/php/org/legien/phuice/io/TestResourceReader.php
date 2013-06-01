<?php

	namespace org\legien\phuice\io;

	use org\legien\phuice\io\FileReader;

	class TestResourceReader
	{
		private $_path;
		
		public function __construct($name)
		{
			$this->_path = implode(DIRECTORY_SEPARATOR, 
				array(
					getcwd(),
					'src', 
					'test', 
					'resources', 
					$name
			));
		}
		
		private function getPath()
		{
			return $this->_path;
		}
		
		public function read()
		{
			$reader = new FileReader($this->getPath());
			return $reader->read();
		}
	}