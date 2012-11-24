<?php

	namespace org\legien\phuice\localization;
	
	use org\legien\phuice\mvc\Model;

	class DictionaryEntry implements Model {
		
		private $placeholder;
		private $language;
		private $translation;
		
		public function setPlaceholder($placeholder) {
			$this->placeholder = $placeholder;
		}
		
		public function setLanguage($language) {
			$this->language = $language;
		}
		
		public function setTranslation($translation) {
			$this->translation = $translation;
		}
		
		public function getPlaceholder() {
			return $this->placeholder;
		}
		
		public function getLanguage() {
			return $this->language;
		}
		
		public function getTranslation() {
			return $this->translation;
		}
		
		public function toArray() {
			return array(
				'placeholder' => $this->getPlaceholder(),
				'language' => $this->getLanguage(),
				'translation' => $this->getTranslation()
			);
		}
	}