<?php

	/*
	 * A wrapper for calling phpunit from within pdt.
	 */

	$command = 'php phpunit/phpunit.phar';

	passthru($command);