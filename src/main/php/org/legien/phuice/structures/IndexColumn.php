<?php

	namespace org\legien\phuice\structures;
	
	/**
	 * Model describing a table column
	 * 
	 */
	class IndexColumn 
	{
		/**
		 * The column sequence number in the index, starting with 1.
		 * 
		 * @var int
		 */		
		protected $seqInIndex;

		/**
		 * The column's name.
		 * 
		 * @var string		
		 */
		protected $name;

		/**
		 * How the column is sorted in the index. In MySQL, this can 
		 * have values "A" (Ascending) or NULL (Not sorted).
		 * 
		 * @var string
		 */
		protected $collation;

		/**
		 * The number of indexed characters if the column is only 
		 * partly indexed, NULL if the entire column is indexed.
		 * 
		 * @var string
		 */
		protected $subPart;

		/**
		 * Whether the column may contain NULL values.
		 * 
		 * @var boolean
		 */
		protected $null;
		
		/**
		 * magic function...
		 * 
		 * @return mixed
		 */
		public function __call($name, $arguments) 
		{
			$key = lcfirst(substr($name, 3));
			if (!isset($this->$key)) 
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
				'Seq_in_index'	=> function($value) { return array('seqInIndex',	(int)$value); },
				'Column_name'	=> function($value) { return array('name',			(string)$value); },
				'Collation'		=> function($value) { return array('collation',		$value); },
				'Sub_part'		=> function($value) { return array('subPart',		$value); },
				'Null'			=> function($value) { return array('null',			($value == 'YES')); }
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