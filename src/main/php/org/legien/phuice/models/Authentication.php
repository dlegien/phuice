<?php
	namespace org\legien\phuice\models;

	class Authentication {

		private $id;
		private $username;
		private $password;
		private $language;

		public function setUsername($username) {
			$this->username = $username;
		}

		public function setPassword($password) {
			$this->password = $password;
		}

		public function getUsername() {
			return $this->username;
		}

		public function getPassword() {
			return $this->password;
		}

		public function setId($id) {
			$this->id = $id;
		}
	
		public function getId() {
			return $this->id;
		}
		
		public function setLanguage($language) {
			$this->language = $language;
		}
		
		public function getLanguage() {
			return $this->language;
		}
	}
