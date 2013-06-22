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
	}