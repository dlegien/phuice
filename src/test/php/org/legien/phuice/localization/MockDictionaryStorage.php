<?php
	
	namespace org\legien\phuice\localization;
	
	class MockDictionaryStorage implements DictionaryStorage {
		
		private $_dictionary;
		
		public function __construct($dictionary) {
			$this->setDictionary($dictionary);
		}
		
		private function getDictionary() {
			return $this->_dictionary;
		}
		
		private function setDictionary($dictionary) {
			$this->_dictionary = $dictionary;
			return $this;
		}
		
		private function hasEntryFor($string) {
			return array_key_exists($string, $this->getDictionary());
		}
		
		private function getEntryFor($string) {
			return $this->_dictionary[$string];
		}
		
		public function findTranslationByPlaceholder($string) {
			if($this->hasEntryFor($string)) {
				return $this->getEntryFor($string);
			}
			else {
				return $string;
			}
		}
		
	}