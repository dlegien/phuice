<?php

	namespace org\legien\phuice\localization;

	interface DictionaryStorage {

		public function findTranslationByPlaceholder($placeholder);
	}