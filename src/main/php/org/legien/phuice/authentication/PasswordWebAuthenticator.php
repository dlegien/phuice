<?php

	namespace org\legien\phuice\authentication;
	
	use org\legien\phuice\authentication\WebAuthenticator;
	use org\legien\phuice\mvc\ViewWrapper;
	use org\legien\phuice\storages\AuthenticationStorage;
	use org\legien\phuice\sessions\SessionManager;
	use org\legien\phuice\authentication\HashWrapper;

	/**
	 * A web authenticator for the use with passwords.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	authentication
	 */
	class PasswordWebAuthenticator implements WebAuthenticator 
	{
		/**
		 * The view.
		 *
		 * @var	ViewWrapper
		 */
		private $_view;
		
		/**
		 * The gateway to the authentication information.
		 * 
		 * @var	AuthenticationStorage
		 */
		private $_gateway;
		
		/**
		 * The session manager.
		 * 
		 * @var	SessionManager
		 */
		private $_sessionManager;
		
		/**
		 * The hash wrapper.
		 * 
		 * @var	HashWrapper
		 */
		private $_hashWrapper;

		/**
		 * Creates a new instance.
		 * 
		 * @param	ViewWrapper				$view			The view.
		 * @param	AuthenticationStorage	$gateway		The gateway to authentication information.
		 * @param	SessionManager			$sessionManager	The session manager.
		 * @param	HashWrapper				$hashWrapper	The hash wrapper.
		 */
		public function __construct(ViewWrapper $view, AuthenticationStorage $gateway, SessionManager $sessionManager, HashWrapper $hashWrapper) 
		{
			$this->setView($view);
			$this->setGateway($gateway);
			$this->setSessionManager($sessionManager);
			$this->setHashWrapper($hashWrapper);
		}
		
		/**
		 * Sets the hash wrapper.
		 * 
		 * @param	HashWrapper	$hashwrapper	The hash wrapper.
		 */
		private function setHashWrapper(HashWrapper $hashwrapper) 
		{
			$this->_hashWrapper = $hashwrapper;
		}

		/**
		 * Sets the session manager.
		 * 
		 * @param	SessionManager	$sessionManager	The session manager.
		 */
		private function setSessionManager(SessionManager $sessionManager) 
		{
			$this->_sessionManager = $sessionManager;
		}

		/**
		 * Sets the storage for authentication information.
		 * 
		 * @param	AuthenticationStorage	$gateway	The storage for authentication information.
		 */
		private function setGateway(AuthenticationStorage $gateway) 
		{
			$this->_gateway = $gateway;
		}

		/**
		 * Returns the session manager
		 * 
		 * @return	SessionManager
		 */
		private function getSessionManager() 
		{
			return $this->_sessionManager;
		}

		/**
		 * Returns the storage for authentication information.
		 * 
		 * @return	AuthenticationStorage
		 */
		private function getGateway() 
		{
			return $this->_gateway;
		}
		
		/**
		 * Returns the hash wrapper.
		 * 
		 * @return	HashWrapper
		 */
		private function getHashWrapper() 
		{
			return $this->_hashWrapper;
		}

		/**
		 * Returns whether the user is authenticated. This resolves to true
		 * if the session manager reports an active and valid session.
		 * 
		 * @return	boolean
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
		 * Verifies a password using the given hash.
		 * 
		 * @param	string	$hash	The hash.
		 * @param	string	$input	The password.
		 * 
		 * @return	boolean
		 */
		public function verifyPassword($hash, $input) 
		{
			return $this->getHashWrapper()->verifyPassword($hash, $input);
		}

		/**
		 * Authenticates the user by verifying the password, starting a
		 * session and redirecting the user.
		 * 
		 * @param	string	$username	The username.
		 * @param	string	$password	The password.
		 * @param	string	$redirect	Where to redirect the user.
		 */
		public function authenticate($username, $password, $redirect) 
		{
			$gateway = $this->getGateway();
			if($user = $gateway->findByUsername($username)) 
			{
				if($user->isActive() && $this->verifyPassword($user->getPassword(), $password)) 
				{
					$this->getSessionManager()->startSession($user->getId(), time());
					$this->getSessionManager()->setLanguage($user->getLanguage());
					$this->redirect($redirect);
				}
				else
				{
					$this->renderFailure($redirect, 'password');
				}
			}
			else 
			{
				$this->renderFailure($redirect, 'username');
			}
		}

		/**
		 * Logs the user out by destroying the session.
		 * 
		 * @param	string	$redirect	Where to redirect the user.
		 */
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
			header('Location: ' . $this->getView()->urlunescape($redirect));
		}

		private function setView(ViewWrapper $view) {
			$this->_view = $view;
		}

		private function getView() {
			return $this->_view;
		}

		public function showAuthentication() {

			$this->getView()->redirect = $_SERVER['REDIRECT_URL'];
			$this->getView()->render();
		}

	}
