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
		 * (non-PHPdoc)
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
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\io\IWriter::write()
		 */
		public function write($resourceName, $content)
		{
			file_put_contents($resourceName, $content);
		}
	}