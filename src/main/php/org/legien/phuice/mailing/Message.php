<?php

	namespace org\legien\phuice\mailing;

	use org\legien\phuice\contacts\Contact;

	class Message {

		private $_from;
		private $_to;
		private $_message;
		private $_encoding;

		public function __construct(Contact $from, Contact $to, $message, $encoding = 'utf-8') {
			$this->setFrom($from);
			$this->setTo($to);
			$this->setMessage($message);
			$this->setEncoding($encoding);
		}

		public function setFrom(Contact $from) {
			$this->_from = $from;
			return $this;
		}

		public function setTo(Contact $to) {
			$this->_to = $to;
			return $this;
		}

		public function setMessage($message) {
			$this->_message = $message;
			return $this;
		}

		public function setEncoding($encoding) {
			$this->_encoding = $encoding;
			return $this;
		}

		public function getFrom() {
			return $this->_from;
		}

		public function getTo() {
			return $this->_to;
		}

		public function getMessage() {
			return $this->_message;
		}

		public function getEncoding() {
			return $this->_encoding;
		}
	}
