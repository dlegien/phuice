<?php

	function customAutoload($className)
	{
		try {
			$filenameSrc = 'src/main/php/' . str_replace('\\', '/', $className) . '.php';
			$filenameTest = 'src/test/php/' . str_replace('\\', '/', $className) . '.php';
			if(file_exists($filenameSrc)) {
				require_once($filenameSrc);
			}
			elseif(file_exists($filenameTest)) {
				require_once($filenameTest);
			}
	    		else {
				echo $filenameTest;
				throw new \Exception('Could not load class ' . $className . '!');
      			}
    		}
    		catch (Exception $e)
    		{
    			echo $e->getMessage()."<br>";
			
		}
  	}

	spl_autoload_register('customAutoload');
