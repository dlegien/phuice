<?php

	namespace org\legien\phuice\testing;
	
	/**
	 * An abstract Mock that offers methods for registering, resetting
	 * and retrieving calls to Mocks.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	testing
	 *
	 */
	abstract class AbstractMock
	{
		/**
		 * The list of calls.
		 * 
		 * @var array
		 */
		private $calls = array();
		
		/**
		 * The return values for the Mock.
		 * 
		 * @var array
		 */
		private $returnValues = array();
				
		
		public function __construct($returnValues = array())
		{
			$this->setReturnValues($returnValues);
		}
		
		/**
		 * Registers a call to the Mock.
		 * 
		 * @param string	$class		The class of the Mock.
		 * @param string	$method		The method of the Mock.
		 * @param array		$arguments	The arguments of the method.
		 */
		public function registerCall($class, $method, $arguments)
		{
			$this->calls[] = array($class, $method, $arguments);
		}
		
		/**
		 * Returns the calls received by the Mock.
		 * 
		 * @return array
		 */
		public function getCalls()
		{
			return $this->calls;
		}
		
		/**
		 * Resets the calls received by the Mock.
		 */
		public function resetCalls()
		{
			$this->calls = array();
		}
		
		/**
		 * Sets the return values.
		 * 
		 * @param array $returnValues The return values.
		 */
		private function setReturnValues($returnValues)
		{
			$this->returnValues = $returnValues;
		}
		
		/**
		 * Returns the return value for the method if it is set or
		 * NULL otherwise.
		 * 
		 * @param string $method The name of the method.
		 * 
		 * @return mixed
		 */
		public function getReturnValue($method)
		{
			return isset($this->returnValues[$method]) ? $this->returnValues[$method] : NULL;
		}
	}