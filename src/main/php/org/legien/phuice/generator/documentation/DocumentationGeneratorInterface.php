<?php

	namespace org\legien\phuice\generator\documentation;
	
	/**
	 * The DocumentationGeneratorInterface specifies the methods required to
	 * implement a DocumentationGenerator. The DocumentationGenerator is used
	 * to generated documentation blocks specific to a certain language.
	 * 
	 * @author		Rüdiger Willmann <r.willmann@design-it.de>
	 * @package		org.legien.phuice.generator
	 * @subpackage	documentation
	 * 
	 */
	interface DocumentationGeneratorInterface
	{
		/**
		 * formats a string as a docblock
		 * 
		 * @param	string	$block	The block to format
		 * 
		 * @return	string 
		 */
		public function generateDocBlock($block);

		/**
		 * generates an announcement line within an docblock
		 * 
		 * @param	string	$...
		 * @return	string	announcement line
		 */		
		public function generateDocBlockAnnouncement($name, $value);	
	}
