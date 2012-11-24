<?php

	namespace org\legien\phuice\localization;
	
	use org\legien\phuice\storages\StorageFilter;
	use org\legien\phuice\storages\AbstractDBStorage;
	use org\legien\phuice\sessions\SessionManager;
	
	class DBDictionaryStorage extends AbstractDBStorage implements DictionaryStorage {
		
		public function __construct(SessionManager $sessionManager, $language, $connection, $table, $model) {
			parent::__construct($connection, $table, $model);
			$sessionLanguage = $sessionManager->getLanguage();
			$this->setLanguage(is_null($sessionLanguage) ? $language : $sessionLanguage);
		}
		
		private function setLanguage($language) {
			$this->_language = $language;
		}
		
		private function getLanguage() {
			return $this->_language;
		}
		
		public function findTranslationByPlaceholder($string) {
			if($translation = parent::find(array(
					new StorageFilter('placeholder', '=', $string),
					new StorageFilter('language', '=', $this->getLanguage())
			))) {
				return $translation->getTranslation();	
			}
			return $string;
		}
	}