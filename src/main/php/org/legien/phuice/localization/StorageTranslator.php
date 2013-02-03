<?php

	namespace org\legien\phuice\localization;
	
	class StorageTranslator implements Translator {

		private $_storage;

		public function __construct(DictionaryStorage $storage) {
			$this->setGateway($storage);
		}

		private function setGateway(DictionaryStorage $storage) {
			$this->_storage = $storage;
		}

		public function translate($string) {
			return $this->getStorage()->findTranslationByPlaceholder($string);
		}

		private function getStorage() {
			return $this->_storage;
		}
	}