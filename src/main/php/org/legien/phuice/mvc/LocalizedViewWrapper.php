<?php

	namespace org\legien\phuice\mvc;

	use org\legien\phuice\localization\Translator;

	class LocalizedViewWrapper extends ViewWrapper {
		
		private $_translator;
		
		/**
		 * Creates a new ViewWrapper that uses the given translator
		 * for localization.
		 * 
		 * @param Translator $translator The translator.
		 */
		public function __construct(Translator $translator, $filename, LayoutWrapper $layout = NULL) {
			parent::__construct($filename, $layout);
			$this->setTranslator($translator);
		}
		
		private function setTranslator(Translator $translator) {
			$this->_translator = $translator;
		}
		
		private function getTranslator() {
			return $this->_translator;
		}
		
		public function translate($string) {
			return $this->getTranslator()->translate($string);
		}
	}
