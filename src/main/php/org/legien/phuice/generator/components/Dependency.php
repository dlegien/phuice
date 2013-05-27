<?php

	namespace org\legien\phuice\generator\components;

	/**
	 * The Dependency class.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	components
	 * 
	 */
	class Dependency
	{
		/**
		 * The name of the dependency.
		 *
		 * @var	string
		 */
		private $name;
			
		/**
		 * The alias to use for the dependency.
		 *
		 * @var	string
		 */
		private $alias;
		
		/**
		 * Constructor of the Dependency class.
		 * 
		 * @param	string	$name	
		 * @param	string	$alias	
		 */
		public function __construct($name, $alias = NULL) 
		{
			$this->name = $name;
			$this->alias = $alias;
		}
		
		/**
		 * Sets name to the given value.
		 * 
		 * @param	string	$name	
		 */
		public function setName($name) 
		{
			$this->name = (string)$name;
		}
		
		/**
		 * Sets alias to the given value.
		 * 
		 * @param	string	$alias	
		 */
		public function setAlias($alias) 
		{
			$this->alias = (string)$alias;
		}
		
		/**
		 * Returns the value of name.
		 * 
		 * @return	string
		 */
		public function getName() 
		{
			return (string)$this->name;
		}
		
		/**
		 * Returns the value of alias.
		 * 
		 * @return	string
		 */
		public function getAlias() 
		{
			return (string)$this->alias;
		}
		
		/**
		 * Returns whether the dependency has an alias.
		 * 
		 * @return boolean
		 */
		public function hasAlias()
		{
			return $this->alias != '';
		}
	}