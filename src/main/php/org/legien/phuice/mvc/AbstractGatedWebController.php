<?php

	namespace org\legien\phuice\mvc;

	use org\legien\phuice\mvc\ViewWrapper;
	use org\legien\phuice\authentication\WebAuthenticator;

	abstract class AbstractGatedWebController extends AbstractController {

		private $_authenticator;

		public function __construct(WebAuthenticator $authenticator, ViewWrapper $view) {
			parent::__construct($view);
			$this->setAuthenticator($authenticator);
			$this->getView()->getLayout()->loggedin = $this->isAuthenticated();
		}

		private function setAuthenticator(WebAuthenticator $authenticator) {
			$this->_authenticator = $authenticator;
		}

		private function getAuthenticator() {
			return $this->_authenticator;
		}

		public function renderView() {
			if($this->getAuthenticator()->isAuthenticated()) {
				parent::renderView();
			}
			else {
				$this->getAuthenticator()->showAuthentication();
			}
		}

		protected function isAuthenticated() {
			return $this->getAuthenticator()->isAuthenticated();
		}
	}
