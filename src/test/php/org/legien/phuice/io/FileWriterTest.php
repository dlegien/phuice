<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\io\FileWriter;

	/**
	 * Testcases for the FileWriter.
	 * 
	 * @author		Daniel Legien
	 *
	 */
	class FileWriterTest extends TestBase
	{
		/**
		 * Tests if content can be written to a file.
		 */
		public function testWrite()
		{
			// Preparation
			$writer = new FileWriter();	
			$content = uniqid();			
			$path = 'src/test/resources/tmp/bla.txt';
			
			// Test
			$writer->write($path , $content);
			
			// Verification
			$this->assertFileExists($path);
			$this->assertEquals($content, file_get_contents($path));
		}
		
		/**
		 * Tests if a FileNotFoundException is thrown if the file does
		 * not exist.
		 * 
		 * @expectedException org\legien\phuice\io\FileNotFoundException
		 */
		public function testWriteException()
		{
			// Preparation
			$writer = new FileWriter();
			$content = uniqid();
			$path = 'bogus.bla';
			
			// Test
			$writer->write($path, $content);
		}
		
		/**
		 * Tests whether a file can be written to if it should be locked
		 * exclusively during writing.
		 */
		public function testLockExclusively()
		{
			// Preparation
			$writer = new FileWriter();
			$writer->setLockExclusively(TRUE);
			$content = uniqid();
			$path = 'src/test/resources/tmp/bla.txt';
				
			// Test
			$writer->write($path, $content);

			// Verification
			$this->assertFileExists($path);
			$this->assertEquals($content, file_get_contents($path));
		}
		
		/**
		 * Tests whether a file can be written to if it should be appended
		 * to during writing.
		 */		
		public function testAppend()
		{
			// Preparation
			$writer = new FileWriter();
			$writer->setAppend(TRUE);
			$path = 'src/test/resources/tmp/bla.txt';
			$oldcontent = file_get_contents($path);
			$content = uniqid();
		
			// Test
			$writer->write($path, $content);
		
			// Verification
			$this->assertFileExists($path);
			$this->assertEquals($oldcontent.$content, file_get_contents($path));
		}

		/**
		 * Tests whether a file can be written to if it should be appended
		 * to during writing and locked exclusively.
		 */
		public function testAppendAndLock()
		{
			// Preparation
			$writer = new FileWriter();
			$writer->setAppend(TRUE);
			$writer->setLockExclusively(TRUE);
			$path = 'src/test/resources/tmp/bla.txt';
			$oldcontent = file_get_contents($path);
			$content = uniqid();
		
			// Test
			$writer->write($path, $content);
		
			// Verification
			$this->assertFileExists($path);
			$this->assertEquals($oldcontent.$content, file_get_contents($path));
		}
		
		/**
		 * Tests whether a file can be written to if it should be appended
		 * to during writing and locked exclusively.
		 */
		public function testCreatePath()
		{
			// Preparation
			$writer = new FileWriter();
		
			// Test
			$writer->createPath('path');
			
			// Assertions
			$this->assertFileExists('path');
			
			// Cleanup
			rmdir('path');
		}		
	}