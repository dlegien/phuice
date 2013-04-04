<?php

	namespace org\legien\phuice\routing;
	
	use org\legien\phuice\services\ServiceDirectory;
	
	class CommandlineRouter extends DefaultRouter
	{
		private $directory;
		const CLI_ARGUMENT_SEPARATOR = '-';
		const BASE_SEPARATOR = '/';
		const QUERY_STRING_SEPARATOR = '?';
		const QUERY_STRING_ARGUMENT_SEPARATOR = '&';
		
		private function convertPath($path)
		{
			$base = array();
			$qs = array();
			
			foreach($path as $argument)
			{
				if(strpos($argument, self::CLI_ARGUMENT_SEPARATOR) !== FALSE)
				{
					$qs[] = str_replace(self::CLI_ARGUMENT_SEPARATOR, '', $argument);
				}
				else
				{
					$base[] = $argument;
				}
			}

			$newpath = implode(self::BASE_SEPARATOR, $base);
			if(count($qs) > 0) 
			{
				$newpath .= self::QUERY_STRING_SEPARATOR . implode(self::QUERY_STRING_ARGUMENT_SEPARATOR, $qs);	
			}
			
			return $newpath;
		}
		
		public function route($path)
		{
			parent::route($this->convertPath($path));
		}
		
	}
