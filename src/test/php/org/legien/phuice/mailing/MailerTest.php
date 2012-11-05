<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\mailing\Mailer;
	use org\legien\phuice\mailing\transports\MockTransport;
	use org\legien\phuice\mailing\Message;
	use org\legien\phuice\contacts\Contact;
	use org\legien\phuice\contacts\Name;

	class MailerTest extends TestBase {

		public function setUp() {
			
			$this->_transport = new MockTransport();
		}

		public function testMailing() {

			$from = new Contact(
				new Name('Daniel', 'Legien'),
				'daniel@legien.org');
			$to = new Contact(
				new Name('Stefan', 'Legien'),
				'stefan@legien.org');

			$message = new Message($from, $to, 'Test message');

			$mailer = new Mailer($this->_transport);
			$mailer->send($message);

			$this->assertTrue($this->_transport->hasSent($message));
			$this->assertTrue($this->_transport->hasMail('stefan@legien.org', 1));
		}

	}
