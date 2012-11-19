<?php

	namespace org\legien\phuice\authentication;
	
	/**
	 * Collects access information.
	 * 
	 * @author Daniel Legien
	 *
	 */
	class AccessBox {
		
		/**
		 * The access information
		 * @var array
		 */
		private $_access = array();
		
		/**
		 * The saved keys
		 * @var array
		 */
		private $_keys = array();

		/**
		 * Creates a new AccessBox.
		 * 
		 * @param array $access The access information
		 */
		public function __construct($access = array()) {			
			if(is_array($access)) {
				$this->setAccess($access);
				$this->addKeys($access);
			}
		}
		
		private function setAccess($access) {
			$this->_access = $access;
		}
		
		private function addKeys($access) {
			foreach((array)$access as $acc) {
				$this->addKey($acc->getAccessId());
			}
		}
		
		public function addAccess($access) {
			$this->_access[] = $access;
			$this->addKey($access->getAccessId());
		}
		
		private function addKey($id) {
			$this->_keys[$id] = TRUE;
		}
		
		public function getKeys() {
			return $this->_keys;
		}
		
		public function isIn($id) {
			return array_key_exists($id, $this->getKeys());
		}
	}