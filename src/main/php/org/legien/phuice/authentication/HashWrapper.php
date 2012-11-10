<?php

	namespace org\legien\phuice\authentication;

	/**
	 * A wrapper for hashing algorithms.
	 * 
	 * @author 		Daniel Legien
	 * @package		phuice
	 * @subpackage	authentication
	 */
	interface HashWrapper {
		
		public function verifyPassword($hash, $input);
		
		public function hashPassword($password, $salt);
	}
