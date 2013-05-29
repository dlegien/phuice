<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\exceptions\ClassNotFoundException;
	
	class ClassNotFoundExceptionTest extends TestBase
	{
		
		public function testConstruction()
		{
			$exception = new ClassNotFoundException('the message');
			
			$this->assertEquals('ClassNotFoundException: the message', $exception->getMessage());
		}
	}