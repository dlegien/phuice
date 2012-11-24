<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\localization\StorageTranslator;
	use org\legien\phuice\localization\MockDictionaryStorage;

	class StorageTranslatorTest extends TestBase {

		public function setUp() {
			$this->dictionary = new MockDictionaryStorage(array(
				'L_HELLO'	=>	'HALLO'
			));
		}
		
		public function testConstruction() {

			$translator = new StorageTranslator($this->dictionary);
			$this->assertInstanceOf('org\legien\phuice\localization\StorageTranslator', $translator);
		}
		
		public function testTranslation() {
			
			$translator = new StorageTranslator($this->dictionary);
			$this->assertEquals('HALLO', $translator->translate('L_HELLO'));
			$this->assertEquals('L_GOODBYE', $translator->translate('L_GOODBYE'));
		}

	}
