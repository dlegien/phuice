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

	namespace org\legien\phuice\mvc;
	
	use org\legien\phuice\localization\Translator;
	
	/**
	 * A specialized LayoutWrapper that allows the use of localized
	 * elements.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mvc
	 *
	 */
	class LocalizedLayoutWrapper extends LayoutWrapper 
	{
		/**
		 * The translator.
		 * 
		 * @var Translator
		 */	
		private $_translator;
		
		/**
		 * Creates a new localized layout.
		 * 
		 * @param Translator	$translator	The translator.
		 * @param string		$filename	The filename.
		 */
		public function __construct(Translator $translator, $filename) 
		{
			parent::__construct($filename);
			$this->setTranslator($translator);
		}
		
		/**
		 * Sets the translator.
		 * 
		 * @param Translator $translator The translator.
		 */
		private function setTranslator($translator) 
		{
			$this->_translator = $translator;
		}
		
		/**
		 * Returns the translator.
		 * 
		 * @return Translator
		 */
		private function getTranslator() 
		{
			return $this->_translator;
		}
		
		/**
		 * Translates the given string using the translator.
		 * 
		 * @param string $string The string to translate.
		 */
		public function translate($string) 
		{
			return $this->getTranslator()->translate($string);
		}
	}
