<?php

	namespace org\legien\phuice\generator\languages;

	use org\legien\phuice\generator\components\ClassDefinition;

	/**
	 * The LanguageGeneratorInterface specifies the methods required to
	 * implement a LanguageGenerator.
	 * 
	 * The LanguageGenerator is used to transform a class definition
	 * into the corresponding source code for a specific language.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	languages
	 * 
	 */
	interface LanguageGeneratorInterface
	{
		/**
		 * Generates the source code from the specified class definition.
		 * 
		 * @param	ClassDefinition	$class 	The class definition.
		 * 
		 * @return	string
		 */		
		public function generate(ClassDefinition $class);	
	}
