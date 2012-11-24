<?php

	namespace org\legien\phuice\localization;
	
	interface Translator {
		
		/**
		 * Translates the given string using a dictionary.
		 * 
		 * @param string $string The string to translate.
		 */
		public function translate($string);
	}