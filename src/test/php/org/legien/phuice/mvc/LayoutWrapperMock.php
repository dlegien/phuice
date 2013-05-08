<?php

	namespace org\legien\phuice\mvc;
	
	use org\legien\phuice\testing\AbstractMock;
	
	/**
	 * Mock of the LayoutWrapper.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mvc
	 *
	 */
	class LayoutWrapperMock extends AbstractMock implements ILayoutWrapper
	{
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\ILayoutWrapper::setContent()
		 */
		public function setContent($content)
		{
			$this->registerCall('LayoutWrapperMock', 'setContent', array($content));
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\ILayoutWrapper::render()
		 */
		public function render()
		{
			$this->registerCall('LayoutWrapperMock', 'render', array());
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\ILayoutWrapper::__set()
		 */
		public function __set($name, $value)
		{
			$this->registerCall('LayoutWrapperMock', '__set', array($name, $value));
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\ILayoutWrapper::__get()
		 */
		public function __get($name)
		{
			$this->registerCall('LayoutWrapperMock', '__get', array($name));
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mvc\ILayoutWrapper::__isset()
		 */
		public function __isset($name)
		{
			$this->registerCall('LayoutWrapperMock', '__isset', array($name));
		}
	}