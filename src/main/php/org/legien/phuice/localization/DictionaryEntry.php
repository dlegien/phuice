<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	namespace org\legien\phuice\localization;

	use org\legien\phuice\mvc\Model;

	/**
	 * An entry in a dictionary.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	localization
	 */
	class DictionaryEntry implements Model 
	{
		/**
		 * The placeholder used in templates.
		 * 
		 * @var string
		 */
		private $_placeholder;
		
		/**
		 * The language of the translation. For example de_DE or
		 * en_GB.
		 * 
		 * @var string
		 */
		private $_language;
		
		/**
		 * The translation.
		 * 
		 * @var string
		 */
		private $_translation;

		/**
		 * Sets the placeholder.
		 * 
		 * @param string $placeholder	The placeholder.
		 */
		public function setPlaceholder($placeholder) 
		{
			$this->_placeholder = $placeholder;
		}

		/**
		 * Sets the language. For example de_DE or en_GB.
		 * 
		 * @param string $language	The language.
		 */
		public function setLanguage($language) 
		{
			$this->_language = $language;
		}

		/**
		 * Sets the translation.
		 * 
		 * @param string $translation	The translation.
		 */
		public function setTranslation($translation) 
		{
			$this->_translation = $translation;
		}

		/**
		 * Returns the placeholder.
		 * 
		 * @return string
		 */
		public function getPlaceholder() 
		{
			return $this->_placeholder;
		}

		/**
		 * Returns the language.
		 * 
		 * @return string
		 */
		public function getLanguage() 
		{
			return $this->_language;
		}

		/**
		 * Returns the translation.
		 * 
		 * @return string
		 */
		public function getTranslation() 
		{
			return $this->_translation;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\Model::toArray()
		 */
		public function toArray() 
		{
			return array(
				'placeholder' => $this->getPlaceholder(),
				'language' => $this->getLanguage(),
				'translation' => $this->getTranslation()
			);
		}
	}