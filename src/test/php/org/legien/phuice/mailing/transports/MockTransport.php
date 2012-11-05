<?php

	namespace org\legien\phuice\mailing\transports;

	use org\legien\phuice\mailing\Message;
	use org\legien\phuice\contacts\Contact;

	class MockTransport implements Transport {

		private $_sent;

		public function __construct() {
			$this->_queue = array();
			$this->_mailboxes = array();
		}

		public function send(Message $message) {
			$this->_queue[] = $message;
			$this->_moveToMailbox($message);
		}

		private function _moveToMailBox(Message $message) {
			
			if(!$this->_hasMailbox($message->getTo())) {
				$this->_createMailbox($message->getTo());
			}

			$this->_addToMailbox($message);
		}

		private function _addToMailbox(Message $message) {
			$this->_mailboxes[$message->getTo()->getEmail()][] = $message;
		}

		private function _hasMailbox(Contact $contact) {
			return key_exists($contact->getEmail(), $this->_mailboxes);
		}

		private function _createMailbox(Contact $contact) {
			$this->_mailboxes[$contact->getEmail()] = array();
		}

		public function hasSent(Message $message) {
			return in_array($message, $this->_queue);
		}

		private function _mailCount($recipient) {
			if(isset($this->_mailboxes[$recipient])) {
				return count($this->_mailboxes[$recipient]);
			}
			return 0;
		}

		public function hasMail($recipient, $count = -1) {
			if($count == -1) {
				return $this->_mailCount($recipient) > 0;
			}
			else {
				return $this->_mailCount($recipient) == $count;
			}
		}
	}
