<?php

	namespace org\legien\phuice\generator;
	
	/**
	 * The AbstractGenerator implements some methods required by all generators
	 * creating source code, like indenting and concatenating lines of code.
	 * 
	 * @author		Rüdiger Willmann <r.willmann@design-it.de>
	 * @package		org.legien.phuice
	 * @subpackage	generator
	 * 
	 */
	abstract class AbstractGenerator
	{
		/**
		 * concats multiple strings to one string
		 * actually an alias for concat_ws('', [$..[, $..]])
		 * 
		 * @param	string $...
		 * @return	string
		 */
		protected function concat()
		{
			$args = func_get_args();
			array_unshift($args, '');
			return call_user_func_array(array($this, 'concat_ws'), $args);
		}
	
		/**
		 * concats multiple strings to one string using specified glue.
		 * Pretty much like implode, but with numerous parameters
		 * 
		 * @param	string $glue
		 * @param	string $...
		 * @param	string $...
		 * @return	string
		 */
		protected function concat_ws($glue)
		{
			$args = func_get_args();
			array_shift($args);
			return implode($glue, $args);
		}
		
		/**
		 * takes a given text and indents it
		 * 
		 * @param	string $block
		 * @param	string $indent
		 * @param	string $linefeed
		 * @return	string
		 */
		protected function indentTextBlock($block, $indent = "\t", $linefeed = "\n")
		{
			$content = explode($linefeed, $block);		
			$content = array_map(
				array($this, 'concat'),
				array_fill(0, count($content), $indent),
				$content
			);
			return implode($linefeed, $content);
		}		
		
	}
