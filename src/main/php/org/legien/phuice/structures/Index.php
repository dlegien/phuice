<?php

	namespace org\legien\phuice\structures;
	
	use org\legien\phuice\structures\IndexColumn;
	
	/**
	 * Model describing a table index
	 *
	 * @author		Rüdiger Willmann
	 * @package		org.legien.phuice
	 * @subpackage	structures
	 *
	 */
	class Index 
	{
		/**
		 * The name of the index. If the index is the primary 
		 * key, the name is always PRIMARY.
		 * 
		 * @var string
		 */		
		protected $name;

		/**
		 * This field is 0 if the index cannot contain 
		 * duplicates, 1 if it can.
		 * 
		 * @var boolean		
		 */
		protected $unique;

		/**
		 * An estimate of the number of unique values in the index.
		 * 
		 * @var string		
		 */
		protected $cardinality;

		/**
		 * Indicates how the key is packed. NULL if it is not.
		 *
		 * @var string
		 */
		protected $packed;

		/**
		 * The index method used (BTREE, FULLTEXT, HASH, RTREE).
		 * 
		 * @var string
		 */
		protected $index_type;

		/**
		 * Information about the index not described in its own
		 * column, such as disabled if the index is disabled.
		 * 
		 * @var string		
		 */
		protected $comment;

		/**
		 * An array of index columns.
		 * 
		 * @var [Column]
		 */
		protected $indexColumns = array();
		
		/**
		 * Adds a single index column to the list of index columns.
		 * 
		 * @param	Column $column The column.
		 * 
		 */
		public function setIndexColumn(Column $column)
		{
			$this->indexColumns[$column->getName()] = $column;
		}
		
		/**
		 * Adds multiple columns to the list of index columns.
		 * 
		 * @param	[Column] $columns The columns.
		 * 
		 */
		public function setIndexColumns($columns)
		{
			foreach($columns as $column) 
			{
				$this->setIndexColumn($column);
			}
		}
		
		/**
		 * Returns the name of the index. Used to make the
		 * object compareable with array_unique.
		 * 
		 * @return string
		 */
		public function __toString()
		{
		    return $this->name;
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
		 * magic setter...
		 * 
		 */
		public function __set($key, $value) 
		{
			$columns = array(
				'Key_name'		=> function($value) 
				{
					return array(
						'name',
						($value == 'PRIMARY') ? 'primary' : $value 
					);
				},
				'Non_unique'	=> function($value) { return array('unique',		!(bool)$value); },
				'Cardinality'	=> function($value) { return array('cardinality',	$value); },
				'Packed'		=> function($value) { return array('packed',		$value); },
				'Index_type'	=> function($value) { return array('index_type',	$value); },
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