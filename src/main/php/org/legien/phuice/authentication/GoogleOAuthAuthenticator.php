<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	namespace org\legien\phuice\authentication;
	
	use org\legien\phuice\mvc\ViewWrapper;
	use org\legien\phuice\sessions\SessionManager;
	use org\legien\phuice\storages\AuthenticationStorage;	

	/**
	 * An authenticator that uses the google oauth api to authenticate
	 * the user.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	authentication
	 *
	 */
	class GoogleOAuthAuthenticator implements WebAuthenticator
	{
		/**
		 * The view used to communicate with the user.
		 * 
		 * @var ViewWrapper
		 */
		private $_view;
		
		/**
		 * The manager for the session.
		 * 
		 * @var SessionManager
		 */
		private $_sessionManager;
		
		/**
		 * The storage for authentication information.
		 * 
		 * @var AuthenticationStorage
		 */
		private $_gateway;

		/**
		 * Initializes the authenticator.
		 * 
		 * @param ViewWrapper			$view			The view to communicate with the user.
		 * @param AuthenticationStorage	$gateway		The storage for authentication information.
		 * @param SessionManager		$sessionManager	The manager for sessions.
		 */
		public function __construct(ViewWrapper $view, AuthenticationStorage $gateway, SessionManager $sessionManager)
		{
			$this->setView($view);
			$this->setSessionManager($sessionManager);
			$this->setGateway($gateway);
		}
		
		/**
		 * Sets the storage for authentication information.
		 * 
		 * @param AuthenticationStorage $gateway	The storage for authentication information.
		 */
		private function setGateway(AuthenticationStorage $gateway)
		{
			$this->_gateway = $gateway;
		}
		
		/**
		 * Returns the storage for authentication information.
		 * 
		 * @return AuthenticationStorage
		 */
		private function getGateway()
		{
			return $this->_gateway;
		}

		/**
		 * Sets the manager for the session.
		 * 
		 * @param SessionManager $sessionManager	The manager for the session.
		 */
		private function setSessionManager(SessionManager $sessionManager) 
		{
			$this->_sessionManager = $sessionManager;
		}

		/**
		 * Returns the manager for the session.
		 * 
		 * @return SessionManager
		 */
		private function getSessionManager() 
		{
			return $this->_sessionManager;
		}

		/**
		 * Returns whether the user is currently authenticated.
		 * 
		 * @return boolean
		 */
		public function isAuthenticated()
		{
			if($this->getSessionManager()->hasActiveSession()) 
			{
				return TRUE;
			}
			return FALSE;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\authentication\WebAuthenticator::verifyPassword()
		 */
		public function verifyPassword($hash, $input) 
		{
			return FALSE;
		}

		/**
		 * Authenticates the user using the given code.
		 * 
		 * @param string $code	The authentication code.
		 */
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

		/**
		 * Logs the user out of the system and redirects to the given location.
		 * 
		 * @param string $redirect	Where to redirect to.
		 */
		public function logout($redirect)
		{
			$this->getSessionManager()->destroySession();
			$this->redirect($redirect);
		}

		/**
		 * Redirects the user to the specified location.
		 * 
		 * @param string $redirect	Where to redirect to.
		 */
		private function redirect($redirect) 
		{
			header('Location: ' . filter_var($this->getView()->urlunescape($redirect), FILTER_SANITIZE_URL));
		}

		/**
		 * Sets the view used to communicate with the user.
		 * 
		 * @param ViewWrapper $view	The view.
		 */
		private function setView(ViewWrapper $view) 
		{
			$this->_view = $view;
		}

		/**
		 * Returns the view used to communicate with the user.
		 * 
		 * @return ViewWrapper
		 */
		private function getView() 
		{
			return $this->_view;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\authentication\WebAuthenticator::showAuthentication()
		 */
		public function showAuthentication() 
		{
			$this->getView()->redirect = $_SERVER['REDIRECT_URL'];
			$this->getView()->render();
		}
	}
