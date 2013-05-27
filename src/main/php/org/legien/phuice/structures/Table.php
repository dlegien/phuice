<?php

	namespace org\legien\phuice\structures;
	
	
	/**
	 * Model describing a database table.
	 * 
	 * @author		Rüdiger Willmann
	 * @package		org.legien.phuice
	 * @subpackage	structures
	 * 
	 */
	class Table 
	{
		/**
		 * The name of the table.
		 * 
		 * @var string
		 */		
		protected $name;
		
		/**
		 * The type of the table.
		 * 
		 * @var	string
		 */
		protected $type;
		
		/**
		 * Returns the name of the table.
		 * 
		 * @return	string
		 */
		public function getName() 
		{
			return $this->name;
		}

		/**
		 * Returns the type of the table.
		 * 
		 * @return	string
		 */		
		public function getType() 
		{
			return $this->type;
		}
		
		/**
		 * Magic setter method for properties.
		 * 
		 */
		public function __set($fullkey, $value) 
		{
			$columns = array(
				'Tables_in_' => 'name',
				'Table_type' => 'type',
			);
			
			$key = substr($fullkey, 0, 10);			
			
			if (!isset($columns[$key])) 
			{
				throw new \Exception("Unknown Parameter", 1);
			}
			
			$this->{$columns[$key]} = $value;
		}
	}