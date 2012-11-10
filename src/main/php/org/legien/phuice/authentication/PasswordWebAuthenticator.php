<?php

	namespace org\legien\phuice\authentication;
	
	use org\legien\phuice\authentication\WebAuthenticator;
	use org\legien\phuice\mvc\ViewWrapper;
	use org\legien\phuice\storages\AuthenticationStorage;
	use org\legien\phuice\sessions\SessionManager;
	use org\legien\phuice\authentication\HashWrapper;

	class PasswordWebAuthenticator implements WebAuthenticator {

		private $_view;
		private $_gateway;
		private $_sessionManager;
		private $_hashWrapper;

		public function __construct(ViewWrapper $view, AuthenticationStorage $gateway, SessionManager $sessionManager, HashWrapper $hashWrapper) {
			$this->setView($view);
			$this->setGateway($gateway);
			$this->setSessionManager($sessionManager);
			$this->setHashWrapper($hashWrapper);
		}
		
		private function setHashWrapper(HashWrapper $hashwrapper) {
			$this->_hashWrapper = $hashwrapper;
		}

		private function setSessionManager(SessionManager $sessionManager) {
			$this->_sessionManager = $sessionManager;
		}

		private function setGateway(AuthenticationStorage $gateway) {
			$this->_gateway = $gateway;
		}

		private function getSessionManager() {
			return $this->_sessionManager;
		}

		private function getGateway() {
			return $this->_gateway;
		}
		
		private function getHashWrapper() {
			return $this->_hashWrapper;
		}

		public function isAuthenticated() {
			if($this->getSessionManager()->hasActiveSession()) {
				return TRUE;
			}
			return FALSE;
		}

		public function verifyPassword($hash, $input) {
			return $this->getHashWrapper()->verifyPassword($hash, $input);
		}

		public function authenticate($username, $password, $redirect) {

			$gateway = $this->getGateway();
		
			if($user = $gateway->findByUsername($username)) {
				if($this->verifyPassword($user->getPassword(), $password)) {
					$this->getSessionManager()->startSession($user->getId(), time());
					$this->redirect($redirect);
				}
				else
				{
					$this->renderFailure($redirect, 'password');
				}
			}
			else {
				$this->renderFailure($redirect, 'username');
			}
		}

		public function logout($redirect) {
			$this->getSessionManager()->destroySession();
			$this->redirect($redirect);
		}

		private function renderFailure($redirect, $failure) {
			$this->getView()->redirect = $redirect;
			$this->getView()->failure = $failure;
			$this->getView()->render();
		}

		private function redirect($redirect) {
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
