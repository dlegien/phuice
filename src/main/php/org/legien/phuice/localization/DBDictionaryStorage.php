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

	use org\legien\phuice\storages\StorageFilter;
	use org\legien\phuice\storages\AbstractDBStorage;
	use org\legien\phuice\sessions\SessionManager;

	/**
	 * A dictionary that uses a database connection to retrieve
	 * translations.
	 * 
	 * @author 		Daniel Legien
	 * @package 	org.legien.phuice
	 * @subpackage	localization
	 */
	class DBDictionaryStorage extends AbstractDBStorage implements DictionaryStorage 
	{	
		/**
		 * Creates a new instance.
		 * 
		 * @param	SessionManager	$sessionManager	The session manager.
		 * @param 	string	 		$language		The language to use.
		 * @param 	PDOService		$connection		The database connection.
		 * @param 	string			$table			The table holding the dictionary information.
		 * @param 	string			$model			The name of the dictionary model.
		 */
		public function __construct(SessionManager $sessionManager, $language, $connection, $table, $model) 
		{
			parent::__construct($connection, $table, $model);
			$sessionLanguage = $sessionManager->getLanguage();
			$this->setLanguage(is_null($sessionLanguage) ? $language : $sessionLanguage);			
		}

		/**
		 * Sets the language. Valid input would be de_DE or en_GB.
		 * 
		 * @param	string	$language	The language.
		 */
		private function setLanguage($language) 
		{
			$this->_language = $language;
		}

		/**
		 * Returns the language.
		 * 
		 * @return string
		 */
		private function getLanguage() 
		{
			return $this->_language;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\localization\DictionaryStorage::findTranslationByPlaceholder()
		 */
		public function findTranslationByPlaceholder($string) 
		{
			if($translation = parent::find(array(
					new StorageFilter('placeholder', '=', $string),
					new StorageFilter('language', '=', $this->getLanguage())
			))) {
				return $translation->getTranslation();	
			}
			return $string;
		}
	}