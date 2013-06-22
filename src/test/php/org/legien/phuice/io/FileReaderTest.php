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

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\io\FileReader;

	/**
	 * Testcases for the FileReader.
	 * 
	 * @author		Daniel Legien
	 *
	 */
	class FileReaderTest extends TestBase
	{
		/**
		 * Tests if the content of a file can be read correctly.
		 */
		public function testRead()
		{
			$reader = new FileReader('src/test/resources/xml/test-classdefinition-invalid.xml');
			
			$this->assertEquals('asd213das', $reader->read());
		}
		
		/**
		 * Tests if a FileNotFoundException is thrown if the specified file
		 * doesn't exist.
		 * 
		 * @expectedException org\legien\phuice\io\FileNotFoundException
		 */
		public function testFileNotFound()
		{
			$reader = new FileReader('file-that-doesnt-even-exist.txt');
			$reader->read();
		}
	}