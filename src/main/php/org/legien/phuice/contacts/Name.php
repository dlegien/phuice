<?php

	namespace org\legien\phuice\contacts;

	class Name {

		private $_firstname;
		private $_lastname;

		public function __construct($firstname, $lastname) {
			$this->setFirstname($firstname);
			$this->setLastname($lastname);
		}
		
		public function setFirstname($firstname) {
			$this->_firstname = $firstname;
		}

		public function setLastname($lastname) {
			$this->_lastname = $lastname;
		}

		public function getFirstname() {
			return $this->_firstname;
		}

		public function getLastname() {
			return $this->_lastname;
		}
	}
