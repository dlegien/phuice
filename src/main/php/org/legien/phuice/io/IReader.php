<?php

	namespace org\legien\phuice\io;
	
	/**
	 * A reader that can read the content of a resource.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	io
	 *
	 */
	interface IReader
	{
		/**
		 * Reads the content from the resource.
		 *
		 * @return mixed
		 */
		public function read();
	}