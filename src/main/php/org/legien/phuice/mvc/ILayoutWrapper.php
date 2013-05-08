<?php

	namespace org\legien\phuice\mvc;
	
	interface ILayoutWrapper
	{					
		/**
		 * Sets the content of the layout.
		 *
		 * @param string $content	The content.
		 */
		public function setContent($content);
		
		/**
		 * Renders the layout by including the layout file.
		 *
		 */
		public function render();
				
		/**
		 * Magic setter method used to add variables to the layout.
		 * The variables are registered internally.
		 *
		 * @param string	$name	The name of the variable.
		 * @param mixed		$value	The value of the variable.
		 */
		public function __set($name, $value);
		
		/**
		 * Magic getter to return the layout variables. Retrieves
		 * the values from the internal storage.
		 *
		 * @param string	$name	The name of the variable.
		 *
		 * @return mixed
		 */
		public function __get($name);
		
		/**
		 * Magic method to determine if the given variable has been
		 * registered for the layout.
		 *
		 * @param string	$name	The name of the variable.
		 */
		public function __isset($name);
	}