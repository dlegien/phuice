<?php

	namespace org\legien\phuice\mvc;

	class LayoutWrapper {

		private $_filename;
		private $_content;

		public function __construct($filename) {
			$this->setFilename($filename);
		}

		private function setFilename($filename) {
			$this->_filename = $filename;
		}

		private function setLayout($layout) {
			$this->_layout = $layout;
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
	}
