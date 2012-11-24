<?php

	namespace org\legien\phuice\sessions;
	
	use org\legien\phuice\sessions\SessionManager;

	class PHPSessionManager implements SessionManager {

		private $_timeout;

		public function __construct($timeout) {
			if(!isset($_SESSION)) {
				session_start();
			}
			$this->setTimeout($timeout);
		}

		public function setTimeout($timeout) {
			$this->_timeout = $timeout;
		}

		public function hasActiveSession() {
			if(isset($_SESSION['uid'])) {
				return $this->hasValidSession();
			}
			return FALSE;
		}

		public function destroySession() {
			if(isset($_SESSION)) {
				session_start();
				session_destroy();
			}
		}

		private function hasValidSession() {
			if(isset($_SESSION['timeout'])) {
				if($_SESSION['timeout'] > time()) {
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

		public function startSession($uid, $timestamp) {
			session_start();
			$this->setUid($uid);
			$this->updateTimeout($timestamp + $this->_timeout);
		}
	}
