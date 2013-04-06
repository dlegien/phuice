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
	
	/**
	 * A translator that uses a dictionary storage to retrieve translations.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	localization
	 */
	class StorageTranslator implements Translator 
	{
		/**
		 * The dictionary storage.
		 * 
		 * @var DictionaryStorage
		 */
		private $_storage;

		/**
		 * Creates a new instance.
		 * 
		 * @param DictionaryStorage $storage The dictionary storage.
		 */
		public function __construct(DictionaryStorage $storage) 
		{
			$this->setGateway($storage);
		}

		/**
		 * Sets the storage.
		 * 
		 * @param DictionaryStorage $storage The storage.
		 */
		private function setGateway(DictionaryStorage $storage) 
		{
			$this->_storage = $storage;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\localization\Translator::translate()
		 */
		public function translate($string) 
		{
			return $this->getStorage()->findTranslationByPlaceholder($string);
		}

		/**
		 * Returns the storage.
		 * 
		 * @return DictionaryStorage
		 */
		private function getStorage() 
		{
			return $this->_storage;
		}
	}