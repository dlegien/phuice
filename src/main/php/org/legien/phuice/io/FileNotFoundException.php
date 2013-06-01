<?php

	namespace org\legien\phuice\io;
	
	class FileNotFoundException extends IOException
	{
		public function __construct($message)
		{
			parent::__construct('File not found. ' . $message);
		}
	}