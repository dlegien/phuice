<?php

	namespace org\legien\phuice\mailing;

	use org\legien\phuice\mailing\transports\Transport;

	class Mailer {

		private $_transport;		

		public function __construct(Transport $transport) {
			$this->setTransport($transport);
		}

		public function setTransport($transport) {
			$this->_transport = $transport;
			return $this;
		}

		public function getTransport() {
			return $this->_transport;
		}

		public function send(Message $message) {
			$this->getTransport()->send($message);
		}

	}
