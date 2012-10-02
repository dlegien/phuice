<?php

	namespace org\legien\phuice\logging;

	use org\legien\phuice\logging\Logger;

	abstract class AbstractLogger implements Logger {

		private $clazz;

		public function __construct($clazz) {
			date_default_timezone_set('UTC');
			$this->clazz = $clazz;
		}

		protected function getName() {
			return $this->clazz;
		}

		private function getMessage($type, $message) {
			return date('d.m.y H:i:s') . ' ' . $type . ' ' . $this->getName() . ': ' . $message . PHP_EOL;
		}

		protected function getDebugMessage($message) {
			return $this->getMessage('DEBUG', $message);
		}

		protected function getErrorMessage($message) {
			return $this->getMessage('ERROR', $message);
		}

	}
