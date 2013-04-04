<?php

	namespace org\legien\phuice\sessions;
	
	use org\legien\phuice\sessions\SessionManager;

	class GoogleOAuthSessionManager implements SessionManager
	{
		private $_timeout;

		public function __construct($timeout)
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			$this->setTimeout($timeout);
		}

		public function setTimeout($timeout)
		{
			$this->_timeout = $timeout;
		}

		public function hasActiveSession()
		{
			if(isset($_SESSION['token']))
			{
				return $this->hasValidSession();
			}
			return FALSE;
		}

		public function destroySession()
		{
			try 
			{
				require_once 'googleapi/Google_Client.php';
				require_once 'googleapi/contrib/Google_Oauth2Service.php';

				$client = new \Google_Client();
				$client->setApplicationName("Google UserInfo PHP Starter Application");			
			
				if (isset($_SESSION['token'])) 
				{
					$client->setAccessToken($_SESSION['token']);
				}			
				$client->revokeToken();
			}
			catch(\Exception $e)
			{
				// Invalid token
			}
					
			if(isset($_SESSION))
			{
				@session_start();
				session_destroy();
			}
		}

		private function hasValidSession() 
		{
			if(isset($_SESSION['timeout'])) 
			{
				if($_SESSION['timeout'] > time()) 
				{
					$this->updateTimeout(time() + $this->_timeout);
					return TRUE;
				}
				$this->destroySession();
			}
			return FALSE;
		}

		private function updateTimeout($newTimeout) {
			$_SESSION['timeout'] = $newTimeout;
		}

		private function setUid($uid) {
			$_SESSION['uid'] = $uid;
		}
		
		public function getUid() {
			return isset($_SESSION['uid']) ? $_SESSION['uid'] : NULL;
		}
		
		public function setLanguage($language) {
			$_SESSION['language'] = $language;
		}
		
		public function getLanguage() {
			return isset($_SESSION['language']) ? $_SESSION['language'] : NULL;
		}
		
		private function setToken($token)
		{
			$_SESSION['token'] = $token;
		}

		public function startSession($tokens, $timestamp) 
		{	
			list($uid, $token) = $tokens;			
			@session_start();
			$this->setUid($uid);
			$this->setToken($token);
			$this->updateTimeout($timestamp + $this->_timeout);
			
			var_dump($_SESSION);
		}
	}
