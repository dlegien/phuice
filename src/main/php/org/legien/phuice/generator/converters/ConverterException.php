<?php

	namespace org\legien\phuice\generator\converters;
	
	class ConverterException extends \Exception
	{
		public function __construct($message)
		{
			parent::__construct('ConverterException: ' . $message);
		}
	}