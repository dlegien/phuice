<?php

	$pharName = 'phuice';
	$buildPath = 'build/';
	$sourceFolder = 'src/';
	$outputName = $buildPath.$pharName.'.phar';
	
	echo 'Phuice Packer' . PHP_EOL;
	echo '(c) 2013 Daniel Legien' . PHP_EOL;
	echo 'Packaging ' . $pharName . '.phar' . PHP_EOL;
	echo 'Sources: ' . $sourceFolder . PHP_EOL;
	echo 'Buildpath: ' . $buildPath . PHP_EOL;

	if(file_exists($outputName))
	{
		echo PHP_EOL;
		echo 'Phar already exists. Renaming existing one';
		rename($outputName, $buildPath.'backup/'.$pharName.date("Ymd_His", filemtime($outputName)).'.phar');
	}
	
	ini_set('phar.readonly', '0');

	require_once('src/main/php/org/legien/phuice/packaging/Packager.php');

	use org\legien\phuice\packaging\Packager;

	$packager = new Packager($pharName, $buildPath, $sourceFolder);
	$packager->setDefaultStub('main/php/org/legien/phuice/packaging/stub.php');
	$packager->package();
	
	echo PHP_EOL;
	echo 'Packaging done.' . PHP_EOL;