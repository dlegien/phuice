<?php

	namespace org\legien\phuice\mvc;

	class LayoutWrapper {

		private $_vars;
		private $_filename;
		private $_content;

		public function __construct($filename) {
			$this->setFilename($filename);
		}

		private function setFilename($filename) {
			$this->_filename = $filename;
		}

		public function setContent($content) {
			$this->_content = $content;
		}

		public function render() {
			include $this->_filename;
		}

		protected function encodeUrl($url) {
			return str_replace('/', '_', $url);
		}

		protected function decodeUrl($url) {
			return str_replace('_', '/', $url);
		}
		
		public function __set($name, $value) {
			$this->_vars[$name] = $value;
		}
		
		public function __get($name) {
			return $this->_vars[$name];
		}
		
		public function __isset($name) {
			return isset($this->_vars[$name]);
		}
	}
