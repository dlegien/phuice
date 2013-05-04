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

	namespace org\legien\phuice\routing;
	
	use org\legien\phuice\services\ServiceDirectory;
	
	/**
	 * An adapter for commandline routes. It translates commandline routes
	 * into url routes.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	routing
	 */
	class CommandlineRouter extends DefaultRouter
	{
		/**
		 * Indicator for command line arguments.
		 * 
		 * @var string
		 */
		const CLI_ARGUMENT_SEPARATOR = '-';
		
		/**
		 * Separator for parts of a path.
		 * 
		 * @var string
		 */
		const BASE_SEPARATOR = '/';
		
		/**
		 * The seperator for a query string.
		 * 
		 * @var string
		 */
		const QUERY_STRING_SEPARATOR = '?';
		
		/**
		 * The separator for query string arguments.
		 * 
		 * @var string
		 */
		const QUERY_STRING_ARGUMENT_SEPARATOR = '&';
		
		/**
		 * Converts the given path into an URL for the DefaultRouter.
		 * 
		 * @param	array 	$path	The commandline path information.
		 * 
		 * @return	The URL path.
		 */
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
		
		/**
		 * Performs a routing of a commandline route.
		 * 
		 * @param	array 	$path	The commandline path information.
		 */
		public function route($path)
		{
			parent::route($this->convertPath($path));
		}
	}
