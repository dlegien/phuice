<?php

	namespace org\legien\phuice\io;
	
	/**
	 * An exception that indicates a failure during an io
	 * operation.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	io
	 *
	 */
	class IOException extends \Exception
	{
		/**
		 * Constructor.
		 * 
		 * @param string $message The error message.
		 */
		public function __construct($message)
		{
			parent::__construct('IOException: ' . $message);
		}
	}