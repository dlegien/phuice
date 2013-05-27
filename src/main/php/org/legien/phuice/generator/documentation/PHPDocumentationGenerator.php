<?php

	namespace org\legien\phuice\generator\documentation;

	use org\legien\phuice\generator\AbstractGenerator;
	use org\legien\phuice\generator\documentation\DocumentationGeneratorInterface;

	/**
	 * The PhpDocumentationGenerator offers methods to create PHP specific
	 * documentation blocks for the source code.
	 * 
	 * @author		Rüdiger Willmann <r.willmann@design-it.de>
	 * @package		org.legien.phuice.generator
	 * @subpackage	documentation
	 * 
	 */
	class PHPDocumentationGenerator extends AbstractGenerator implements DocumentationGeneratorInterface
	{
		/**
		 * formats a string as a docblock
		 * 
		 * @param	string	$block	The block to format
		 * 
		 * @return	string 
		 */
		public function generateDocBlock($block)
		{
			$linefeed = PHP_EOL;
			return $this->concat_ws(
				$linefeed,
				'/**', 
				$this->indentTextBlock($block, ' * '),
				' */'
			); 
		}

		/**
		 * generates an announcement line within an docblock
		 * 
		 * @param	string	$...
		 * @return	string	announcement line
		 */		
		public function generateDocBlockAnnouncement($name, $value) {
			if ($value == '') return $value;
			
			$args = func_get_args();
			array_unshift($args, "\t");
			return PHP_EOL . '@' . call_user_func_array(array($this, 'concat_ws'), $args);				
		}
		
	}
