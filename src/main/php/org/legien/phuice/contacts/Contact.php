<?php

	namespace org\legien\phuice\contacts;

	use org\legien\phuice\contacts\Name;

	class Contact {

		private $_name;
		private $_email;

		public function __construct(Name $name, $email) {
			$this->setName($name);
			$this->setEmail($email);
		}

		public function setName(Name $name) {
			$this->_name = $name;
			return $this;
		}

		public function setEmail($email) {
			$this->_email = $email;
			return $this;
		}

		public function getName() {
			return $this->_name;
		}

		public function getEmail() {
			return $this->_email;
		}
	}
