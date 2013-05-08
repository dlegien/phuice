<?php

	namespace org\legien\phuice\mvc;
	
	interface IViewWrapper
	{					
			/**
		 * Magic setter method that sets the view variable.
		 * 
		 * @param string	$name	The name.
		 * @param mixed		$value	The value.
		 */
		public function __set($name, $value);
		
		/**
		 * Magic getter method that returns the view variable.
		 *
		 * @param string	$name	The name of the variable.
		 *
		 * @return string
		 */		
		public function __get($name);
		
		/**
		 * Returns whether the given view variable is set.
		 * 
		 * @param string $name The name.
		 */
		public function __isset($name);
			
		/**
		 * Replaces underscores in the given url with a slash.
		 *
		 * @param string	$url	The url.
		 *
		 * @return string
		 */
		public function urlunescape($url);
		
		/**
		 * Replaces slashes in the given url with underscores.
		 *
		 * @param string	$url	The url.
		 *
		 * @return string
		 */
		public function urlescape($url);
		
		/**
		 * Renders the view by buffering it and setting the contents
		 * of the buffer as the content of the layout. Lastly the
		 * layout is rendered.
		 *
		 */
		public function render();
		
		/**
		 * Returns the layout of the view.
		 *
		 * @return ILayoutWrapper
		 */
		public function getLayout();	
	}