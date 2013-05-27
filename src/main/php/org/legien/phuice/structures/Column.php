<?php

	namespace org\legien\phuice\structures;
	
	/**
	 * Model describing the column of a database table.
	 * 
	 * @author		Rüdiger Willmann
	 * @package		org.legien.phuice
	 * @subpackage	structures
	 * 
	 */
	class Column 
	{
		/**
		 * The column's name.
		 * 
		 * @var string
		 */
		protected $name;

		/**
		 * The datatype of the column.
		 * 
		 * @var string
		 */
		protected $type;

		/**
		 * The column's collation for nonbinary string columns, or 
		 * NULL for other columns. 
		 * 
		 * @var string
		 */
		protected $collation;

		/**
		 * Whether the column may contain null values.
		 * 
		 * @var boolean
		 */
		protected $null;

		/**
		 * The default value that is assigned to the column.
		 * 
		 * @var string
		 */
		protected $default;

		/**
		 * Additional information that is available about the column.
		 * 
		 * @var string		
		 */
		protected $extra;

		/**
		 * The privileges the database user has for the column.
		 * 
		 * @var string		
		 */
		protected $privileges;

		/**
		 * A comment set for the column.
		 * 
		 * @var string		
		 */
		protected $comment;
		
		/**
		 * Translates data types from MySQL to PHP.
		 * 
		 * @return string
		 */
		public function getPhpType() 
		{
			if (($this->type == 'float') || ($this->type == 'double')) 
			{
				return 'float';					
			}

			if (strpos($this->type, 'int') !== FALSE) 
			{
				return 'int';
			}
			
			return 'string';
		}

		/**
		 * magic function...
		 * 
		 * @return mixed
		 */
		public function __call($name, $arguments) 
		{
			$key = lcfirst(substr($name, 3));
			if (!property_exists($this, $key)) 
			{
				throw new \Exception("Unknown Parameter: $key"); 
			}
			
			return $this->$key;
		}
				
		/**
		 * magic setter
		 * 
		 * @return	void
		 */
		public function __set($key, $value) 
		{			
			$columns = array(
				'Field'			=> function($value) { return array('name',			$value); },
				'Type'			=> function($value) { return array('type',			$value); },
				'Collation'		=> function($value) { return array('collation',		$value); },
				'Null'			=> function($value) { return array('null',			($value == 'YES')); },
				'Default'		=> function($value) { return array('default',		$value); },
				'Extra'			=> function($value) { return array('extra',			$value); },
				'Privileges'	=> function($value) { return array('privileges',	$value); },
				'Comment'		=> function($value) { return array('comment',		$value); }
			);
						
			if (!isset($columns[$key])) 
			{
				return false;
			}
						
			$closure = $columns[$key];
			list($keyName, $checkedValue) = $closure($value);
			$this->$keyName = $checkedValue;
		}
	}