<?php

	namespace org\legien\phuice\services;

	class ServiceException extends \Exception {

		public function __construct($message) {
			parent::__construct("ServiceException: $message");
		}
	}
