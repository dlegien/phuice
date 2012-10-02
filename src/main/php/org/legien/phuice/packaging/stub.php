<?php

	ini_set('display_errors', '0');
	error_reporting(E_ALL);

	include_once('main/php/org/legien/phuice/Classloader.php');

	new org\legien\phuice\Classloader(
		array(
			'standard' => function($className) {
				$p = 'main/php/'
					. str_replace('\\', '/', $className)
					. '.php';
				return $p;
			}
		)
	);

	__HALT_COMPILER();
