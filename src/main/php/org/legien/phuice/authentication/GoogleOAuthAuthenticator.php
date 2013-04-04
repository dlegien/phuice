<?php

	namespace org\legien\phuice\authentication;
	
	use org\legien\phuice\mvc\ViewWrapper;
	use org\legien\phuice\sessions\SessionManager;
	use org\legien\phuice\storages\AuthenticationStorage;	

	class GoogleOAuthAuthenticator implements WebAuthenticator
	{
		private $_view;
		private $_sessionManager;
		private $_gateway;

		public function __construct(ViewWrapper $view, AuthenticationStorage $gateway, SessionManager $sessionManager)
		{
			$this->setView($view);
			$this->setSessionManager($sessionManager);
			$this->setGateway($gateway);
		}
		
		private function setGateway(AuthenticationStorage $gateway)
		{
			$this->_gateway = $gateway;
		}
		
		private function getGateway()
		{
			return $this->_gateway;
		}

		private function setSessionManager(SessionManager $sessionManager) 
		{
			$this->_sessionManager = $sessionManager;
		}

		private function getSessionManager() 
		{
			return $this->_sessionManager;
		}

		public function isAuthenticated()
		{
			if($this->getSessionManager()->hasActiveSession()) {
				return TRUE;
			}
			return FALSE;
		}

		public function verifyPassword($hash, $input) {
			return FALSE;
		}

		public function authenticate($code)
		{
			if($code != "")
			{
				require_once 'googleapi/Google_Client.php';
				require_once 'googleapi/contrib/Google_Oauth2Service.php';

				$client = new \Google_Client();
				$client->setApplicationName("Google UserInfo PHP Starter Application");
				$oauth2 = new \Google_Oauth2Service($client);
				
				$client->authenticate($code);
				$token = $client->getAccessToken();
				if(!is_null($token))
				{
					$user = $oauth2->userinfo->get();
					$gateway = $this->getGateway();
					
					if($user = $gateway->findByEmail($user['email']))
					{
						$this->getSessionManager()->startSession(array($user->getId(), $token), time());
						$this->getSessionManager()->setLanguage($user->getLanguage());
						$this->redirect($_SESSION['redirect']);
						return;					
					}
				}
			}
			
			$this->getSessionManager()->destroySession();
			$this->redirect($_SESSION['redirect']);
			return;			
		}

		public function logout($redirect)
		{
			$this->getSessionManager()->destroySession();
			$this->redirect($redirect);
		}

		private function renderFailure($redirect, $failure) 
		{
			$this->getView()->redirect = $redirect;
			$this->getView()->failure = $failure;
			$this->getView()->render();
		}

		private function redirect($redirect) 
		{
			header('Location: ' . filter_var($this->getView()->urlunescape($redirect), FILTER_SANITIZE_URL));
		}

		private function setView(ViewWrapper $view) 
		{
			$this->_view = $view;
		}

		private function getView() 
		{
			return $this->_view;
		}

		public function showAuthentication() 
		{
			$this->getView()->redirect = $_SERVER['REDIRECT_URL'];
			$this->getView()->render();
		}
	}
