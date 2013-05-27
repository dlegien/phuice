<?php

	namespace org\legien\phuice\generator\converters;
	
	/**
	 * The ConverterInterface specifies the methods required from a
	 * Converter. The Converter is used to convert input from some
	 * data type to a class definition.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	converters
	 * 
	 */
	interface ConverterInterface
	{
		/**
		 * Returns a class definition for the given data.
		 * 
		 * @param	string	$data	The data to convert.
		 * 
		 * @return	ClassDefinition
		 */
		public function convert($data);
	}