<?php

	require_once('main/php/org/legien/phuice/Classloader.php');

	$loader = org\legien\phuice\Classloader::getInstance();
	$loader->addLoaders(array(
			'standard' => function($className) {
				$p = 'main/php/'
					. str_replace('\\', '/', $className)
					. '.php';
				return $p;
			},
			'testing' => function($className) {
				$p = 'test/php/'
					. str_replace('\\', '/', $className)
					. '.php';
				return $p;
			}
		)
	);

	__HALT_COMPILER();
