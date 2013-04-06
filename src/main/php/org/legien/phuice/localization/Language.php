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
	 * A language.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	localization
	 *
	 */
	class Language implements Model 
	{
		/**
		 * The short name of the language, for example de_DE for
		 * German.
		 * 
		 * @var string
		 */
		private $shortname;
		
		/**
		 * The full name of the language. If you use a 
		 * placeholder here so the names of languages 
		 * can be translated.
		 * 
		 * @var string
		 */
		private $name;
	
		/**
		 * Sets the short name.
		 * 
		 * @param string $shortname The short name.
		 */
		public function setShortname($shortname) 
		{
			$this->shortname = $shortname;
		}

		/**
		 * Returns the short name.
		 * 
		 * @return string
		 */
		public function getShortname() 
		{
			return $this->shortname;
		}

		/**
		 * Sets the name.
		 * 
		 * @param string $name The name.
		 */
		public function setName($name) 
		{
			$this->name = $name;
		}

		/**
		 * Returns the name of the language.
		 * 
		 * @return string
		 */
		public function getName() 
		{
			return $this->name;
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\Model::toArray()
		 */
		public function toArray() 
		{
			return array(
				'name' => $this->getName(),
				'shortname' => $this->getShortname()
			);
		}
	}