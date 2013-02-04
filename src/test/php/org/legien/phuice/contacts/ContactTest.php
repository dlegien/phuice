<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\contacts\Contact;
	use org\legien\phuice\contacts\Name;

	class ContactTest extends TestBase {

		public function testConstruction() {

			$c = new Contact(new Name('Daniel', 'Legien'), 'daniel@legien.org');
			$this->assertEquals($c->getName()->getFirstname(), 'Daniel');
			$this->assertEquals($c->getName()->getLastname(), 'Legien');
		}

	}
