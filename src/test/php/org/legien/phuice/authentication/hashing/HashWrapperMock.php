<?php

	namespace org\legien\phuice\authentication\hashing;
	
	use org\legien\phuice\authentication\HashWrapper;
	use org\legien\phuice\testing\AbstractMock;
	
	class HashWrapperMock extends AbstractMock implements HashWrapper
	{
		/**
		 * Verifies a hashed password.
		 *
		 * @param	string	$hash	The hashed password.
		 * @param	string	$input	The input to check against.
		 *
		 * @return	boolean
		 */
		public function verifyPassword($hash, $input)
		{
			$this->registerCall('HashWrapperMock', 'verifyPassword', array($hash, $input));
		}
		
		/**
		 * Hashes a password using the given salt.
		 *
		 * @param	string	$password	The password to hash.
		 * @param	string	$salt		The salt to use.
		 *
		 * @return	string
		*/
		public function hashPassword($password, $salt)
		{
			$this->registerCall('HashWrapperMock', 'hashPassword', array($password, $salt));
		}
	}