<?php

	ini_set('phar.readonly', '0');

	require_once('src/main/php/org/legien/phuice/packaging/Packager.php');

	use org\legien\phuice\packaging\Packager;

	$packager = new Packager('phuice', 'build/', 'src/');
	$packager->setDefaultStub('main/php/org/legien/phuice/packaging/stub.php');
	$packager->package();
