<?php

	namespace org\legien\phuice;

	class Request {

		private $_parameters = array();

		public function __construct(array $get, array $post) {
			foreach($get as $key => $value) {
				$this->_parameters[$key] = $value;
			}
			foreach($post as $key => $value) {
				$this->_parameters[$key] = $value;
			}
		}

		public function getParameter($name) {
			if(isset($this->_parameters[$name])) {
				return $this->_parameters[$name];
			}
			return NULL;
		}

	}
