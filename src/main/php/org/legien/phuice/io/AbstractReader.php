<?php

	namespace org\legien\phuice\io;
	
	/**
	 * An abstract reader implementation that bundles methods
	 * required by most reader implementations.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	io
	 *
	 */
	abstract class AbstractReader implements IReader
	{
		/**
		 * The name of the resource to read.
		 * 
		 * @var string
		 */
		private $_resourceName;
		
		/**
		 * Constructor.
		 * 
		 * @param string $resourceName The name of the resource to read.
		 */
		public function __construct($resourceName)
		{
			$this->_resourceName = $resourceName;
		}
		
		/**
		 * Returns the name of the resource.
		 * 
		 * @return string
		 */
		protected function getResourceName()
		{
			return $this->_resourceName;
		}
		
		abstract protected function readResource();
		abstract protected function resourceExists();
		abstract protected function throwResourceNotFoundException();
		
		public function read()
		{
			if($this->resourceExists())
			{
				return $this->readResource();
			}
			$this->throwResourceNotFoundException();
		}
	}