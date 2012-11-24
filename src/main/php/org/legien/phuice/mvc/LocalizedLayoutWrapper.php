<?php

	namespace org\legien\phuice\mvc;
	
	use org\legien\phuice\localization\Translator;
	
	class LocalizedLayoutWrapper extends LayoutWrapper {
		
		private $_translator;
		
		public function __construct(Translator $translator, $filename) {
			parent::__construct($filename);
			$this->setTranslator($translator);
		}
		
		private function setTranslator($translator) {
			$this->_translator = $translator;
		}
		
		private function getTranslator() {
			return $this->_translator;
		}
		
		public function translate($string) {
			return $this->getTranslator()->translate($string);
		}
	}