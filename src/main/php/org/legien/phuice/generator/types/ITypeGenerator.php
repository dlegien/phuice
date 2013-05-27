<?php

	namespace org\legien\phuice\generator\types;
	
	interface ITypeGenerator
	{
		/**
		 * Generates the source code for the class definition with
		 * the given name.
		 *
		 * @param	string	$name	The name of the model.
		 *
		 * @return	string
		 */
		public function generate($name);
	}