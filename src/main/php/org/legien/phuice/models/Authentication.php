<?php
	namespace org\legien\phuice\models;

	class Authentication {

		private $id;
		private $username;
		private $password;

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
	}
