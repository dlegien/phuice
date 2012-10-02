<?php

	namespace org\legien\phuice\logging;

	use org\legien\phuice\logging\AbstractLogger;

	class StdOutLogger extends AbstractLogger {

		public function error($message) {
			echo $this->getErrorMessage($message);
		}

		public function debug($message) {
			echo $this->getDebugMessage($message);
		}
	}
