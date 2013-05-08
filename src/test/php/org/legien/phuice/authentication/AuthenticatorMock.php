<?php

	namespace org\legien\phuice\authentication;
	
	use org\legien\phuice\testing\AbstractMock;
	
	class AuthenticatorMock extends AbstractMock implements WebAuthenticator
	{
		private $isAuthenticated;
		
		public function __construct($isAuthenticated)
		{
			$this->isAuthenticated = $isAuthenticated;
		}
		
		/**
		 * Shows the authentication form of the authenticator.
		 */
		public function showAuthentication()
		{
			$this->registerCall('AuthenticatorMock', 'showAuthentication', array());
		}
		
		/**
		 * Verifies the given password input with the given hash.
		 *
		 * @param	string	$hash	The hash to check against.
		 * @param	string	$input	The user input password.
		 *
		 * @return	boolean
		*/
		public function verifyPassword($hash, $input)
		{
			$this->registerCall('AuthenticatorMock', 'verifyPassword', array($hash, $input));
		}	
		
		public function isAuthenticated()
		{
			$this->registerCall('AuthenticatorMock', 'isAuthenticated', array());
			return $this->isAuthenticated;
		}
	}
