<?php

	namespace org\legien\phuice\mvc;
	
	class ViewWrapperMock implements IViewWrapper
	{
		/**
		 * The layout.
		 * 
		 * @var ILayoutWrapper
		 */
		private $layout;
		
		private $vars;
		
		public function __construct(ILayoutWrapper $layout)
		{
			$this->layout = $layout;
			$this->vars = array();
		}
		
		public function __set($name, $value)
		{
			$this->vars[$name] = $value;
		}
		
		public function __get($name)
		{
			return $this->vars[$name];
		}
		
		public function __isset($name)
		{
			return isset($this->vars[$name]);
		}
			
		public function urlunescape($url)
		{
			
		}
		
		public function urlescape($url)
		{
			
		}
		
		public function render()
		{
			
		}
		
		public function getLayout()
		{
			return $this->layout;
		}
		
		public function getVariables()
		{
			return $this->vars;
		}
	}