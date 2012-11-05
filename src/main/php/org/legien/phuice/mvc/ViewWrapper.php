<?php

	namespace org\legien\phuice\mvc;

	class ViewWrapper {

		private $_filename;
		private $_layout;

		public function __construct($filename, LayoutWrapper $layout = NULL) {
			$this->setFilename($filename);
			$this->setLayout($layout);
		}

		private function setFilename($filename) {
			$this->_filename = $filename;
		}

		private function setLayout($layout) {
			$this->_layout = $layout;
		}

		public function __get($name) {
			return '';
		}

		private function buffer() {
			ob_start();
			include $this->_filename;
			$buffer = ob_get_contents();
			ob_end_clean();
			return $buffer;
		}

		public function urlunescape($url) {
			return str_replace('_', '/', $url);
		}

		public function urlescape($url) {
			return str_replace('/', '_', $url);
		}

		public function render() {
			if(!is_null($this->_layout)) {
				$this->_layout->setContent(
					$this->buffer()
				);
				$this->_layout->render();
			}
			else {
				include $this->_filename;
			}
		}

		public function getLayout() {
			return $this->_layout;
		}

	}
