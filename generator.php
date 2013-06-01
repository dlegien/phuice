<?php

	$phuicePath = 'build/phuice.phar';
	$database = 'phuice';
	$hostname = 'localhost';
	$username = 'username';
	$password = 'password';
	$type = 'mysql';
	$outputDir = 'generated';
	
	$rootNamespace = 'org\\legien\\phuice';

	if(!file_exists($phuicePath))
	{
		die('Could not load framework.');
	}
	
	include_once('build/phuice.phar');
	
	$languageGenerator = new org\legien\phuice\generator\languages\PHPGenerator();
	
	$pdo = new org\legien\phuice\services\database\PDOService(
		new org\legien\phuice\pathing\evaluators\SQLStatementEvaluator,
		$type,
		$database,
		$hostname,
		$username,
		$password
	);
	
	$generator = new org\legien\phuice\generator\SimpleGenerator(
		$outputDir,																				// output base path
		$rootNamespace,
		new org\legien\phuice\structures\StructureGateway($pdo),								// Gateway to retrieve database structure
		new org\legien\phuice\generator\types\ModelGenerator($languageGenerator),				// Generator for model classes
		new org\legien\phuice\generator\types\phuice\DBStorageGenerator($languageGenerator), 	// Generator for gateway classes
		new org\legien\phuice\io\FileWriter()
	);
	$generator->Generate();
	
	
