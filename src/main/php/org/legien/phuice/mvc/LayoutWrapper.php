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

	/**
	 * A wrapper for a layout which encapsulates the different views.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mvc
	 *
	 */
	class LayoutWrapper 
	{
		/**
		 * The variables of the layout.
		 * 
		 * @var array
		 */
		private $_vars;
		
		/**
		 * The filename of the layout file.
		 * 
		 * @var string
		 */
		private $_filename;
		
		/**
		 * The content of the layout.
		 * 
		 * @var string
		 */
		private $_content;

		/**
		 * Creates a new LayoutWrapper.
		 * 
		 * @param string $filename	The name of the layout file.
		 */
		public function __construct($filename) 
		{
			$this->setFilename($filename);
		}

		/**
		 * Sets the filename.
		 * 
		 * @param string $filename	The filename.
		 */
		private function setFilename($filename) 
		{
			$this->_filename = $filename;
		}

		/**
		 * Sets the content of the layout.
		 * 
		 * @param string $content	The content.
		 */
		public function setContent($content) 
		{
			$this->_content = $content;
		}

		/**
		 * Renders the layout by including the layout file.
		 * 
		 */
		public function render() 
		{
			include $this->_filename;
		}

		/**
		 * Encodes the given url by replacing all slashes with
		 * underscores.
		 * 
		 * @param string $url	The url to encode.
		 * 
		 * @return string
		 */
		protected function encodeUrl($url) 
		{
			return str_replace('/', '_', $url);
		}

		/**
		 * Decodes the given url by replacing all underscores
		 * with slashes.
		 * 
		 * @param string $url	The url to decode.
		 * 
		 * @return string
		 */
		protected function decodeUrl($url) 
		{
			return str_replace('_', '/', $url);
		}
		
		/**
		 * Magic setter method used to add variables to the layout.
		 * The variables are registered internally.
		 * 
		 * @param string	$name	The name of the variable.
		 * @param mixed		$value	The value of the variable.
		 */
		public function __set($name, $value) 
		{
			$this->_vars[$name] = $value;
		}
		
		/**
		 * Magic getter to return the layout variables. Retrieves
		 * the values from the internal storage.
		 * 
		 * @param string	$name	The name of the variable.
		 * 
		 * @return mixed
		 */
		public function __get($name) 
		{
			return $this->_vars[$name];
		}
		
		/**
		 * Magic method to determine if the given variable has been
		 * registered for the layout.
		 * 
		 * @param string	$name	The name of the variable.	
		 */
		public function __isset($name) 
		{
			return isset($this->_vars[$name]);
		}
	}
