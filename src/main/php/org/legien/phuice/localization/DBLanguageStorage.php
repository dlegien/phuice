<?php

	namespace org\legien\phuice\localization;
	
	use org\legien\phuice\storages\AbstractDBStorage;
	
	class DBLanguageStorage extends AbstractDBStorage implements LanguageStorage {
		
		public function findAll() {
			return parent::findAll();
		}
	}