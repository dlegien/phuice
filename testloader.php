<?php

	function customAutoload($className)
	{
		try {
			$filenameSrc = __DIR__ . '/src/main/php/' . str_replace('\\', '/', $className) . '.php';
			$filenameTest = __DIR__ . '/src/test/php/' . str_replace('\\', '/', $className) . '.php';
			$filenameUnit = __DIR__ . '/phpunit/' . str_replace('_', '/', $className) . '.php';
			if(file_exists($filenameSrc)) {
				require_once($filenameSrc);
			}
			elseif(file_exists($filenameTest)) {
				require_once($filenameTest);
			}
			elseif(file_exists($filenameUnit)) {
				require_once($filenameUnit);
			}
	    	else {
				throw new \Exception('Could not load class ' . $className . ' from ' . $filenameSrc . ', ' . $filenameTest . ' or ' . $filenameUnit .'!');
      		}
    	}
    	catch (Exception $e)
    	{
    		echo $e->getMessage()."<br>";
		}
  	}

	spl_autoload_register('customAutoload');
