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
	 * A wrapper for a view that is used to display information to the
	 * user.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mvc
	 *
	 */
	class ViewWrapper 
	{
		/**
		 * The name of the view file.
		 * 
		 * @var string
		 */
		private $_filename;
		
		/**
		 * The LayoutWrapper of the view.
		 * 
		 * @var LayoutWrapper
		 */
		private $_layout;

		/**
		 * Creates a new view.
		 * 
		 * @param string		$filename	The name of the view file.
		 * @param LayoutWrapper	$layout		The layout of the view.
		 */
		public function __construct($filename, LayoutWrapper $layout = NULL) 
		{
			$this->setFilename($filename);
			$this->setLayout($layout);
		}

		/**
		 * Sets the name of the view file.
		 * @param string	$filename	The name of the file.
		 */
		private function setFilename($filename) 
		{
			$this->_filename = $filename;
		}

		/**
		 * Sets the layout of the view.
		 * 
		 * @param LayoutWrapper $layout	The layout.
		 */
		private function setLayout($layout) 
		{
			$this->_layout = $layout;
		}

		/**
		 * Magic getter method that returns an empty string for
		 * undefined variables
		 * 
		 * TODO: Review
		 * 
		 * @param string	$name	The name of the variable.
		 * 
		 * @return string
		 */
		public function __get($name) 
		{
			return '';
		}

		/**
		 * Reads the layout into a buffer and returns it.
		 * 
		 * @return string
		 */
		private function buffer() 
		{
			ob_start();
			include $this->_filename;
			$buffer = ob_get_contents();
			ob_end_clean();
			return $buffer;
		}

		/**
		 * Replaces underscores in the given url with a slash.
		 * 
		 * @param string	$url	The url.
		 * 
		 * @return string
		 */
		public function urlunescape($url) 
		{
			return str_replace('_', '/', $url);
		}

		/**
		 * Replaces slashes in the given url with underscores.
		 * 
		 * @param string	$url	The url.
		 * 
		 * @return string
		 */
		public function urlescape($url) 
		{
			return str_replace('/', '_', $url);
		}

		/**
		 * Renders the view by buffering it and setting the contents
		 * of the buffer as the content of the layout. Lastly the
		 * layout is rendered.
		 * 
		 */
		public function render() 
		{
			if(!is_null($this->_layout)) 
			{
				$this->_layout->setContent(
					$this->buffer()
				);
				$this->_layout->render();
			}
			else 
			{
				include $this->_filename;
			}
		}

		/**
		 * Returns the layout of the view.
		 * 
		 * @return LayoutWrapper
		 */
		public function getLayout() 
		{
			return $this->_layout;
		}
	}
