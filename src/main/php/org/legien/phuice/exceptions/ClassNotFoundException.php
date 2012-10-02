<?php

	namespace org\legien\phuice\exceptions;

	class ClassNotFoundException extends \Exception {

		public function __construct($message) {
			parent::__construct($message);
		}
	}
