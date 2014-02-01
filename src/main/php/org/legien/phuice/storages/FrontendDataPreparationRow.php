<?php

	namespace org\legien\phuice\storages;

	/**
	 * A specific row format for the data set used by
	 * FrontendDataPreparation module
	 * 
	 * @author		Philipp Pajak
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	class FrontendDataPreparationRow
	{
		/**
		 * Cells
		 * 
		 * @var array
		 */
		private $cells;

		/**
		 * Is this row a header row?
		 * 
		 * @var boolean
		 */
		private $isHeader;

		/**
		 * The color for the whole row
		 * 
		 * @var string
		 */
		private $rowColor;

		/**
		 * Options for the whole row
		 * 
		 * @var array
		 */
		private $options;

		/**
		 * Constructor.
		 * 
		 * @param array				$columns 			Columns of the row
		 * @param array				$options 			Options of the row
		 * @param boolean			$isHeader 			True if this row is a header
		 *
		 *	options: (all optional)
		 *		COLOR 		=>		sets the color of the row
		 *		ID 			=>		sets an ID to be used as a AJAX reference
		 *		LINK 		=>		make the row clickable with the link
		 *		HASSTRIPES 	=> 		generates a general padding on the left that is colored when a cell shall be colored
		 *		STRIPECOLOR	=>		color of the stripe
		 *
		 *
		 */
		public function __construct($cells = null, $options = null, $isHeader = false)
		{
			if($cells)
				$this->cells = $cells;

			if($options)
				$this->options = $options;

			$this->isHeader = $isHeader;

			$this->parseOptions($this->options);
		}


		/**
		 * Parse the options given for the row
		 * 
		 * @param array 			$options 				Options of the row, see the constructor for more information
		 */
		public function parseOptions($options) 
		{
			if($this->options && array_key_exists("COLOR", $this->options))
				$this->rowColor = $this->options["COLOR"];
		}

		/**
		 * Adds a column to the row set
		 * 
		 * @param string			$data 				The data/content of the row
		 * @param array				$options 			Additional options for the cell
		 *
		 *	options: (all optional)
		 *		COLOR 			=>			sets the color of the cell or if header for the whole column
		 *		ID 				=>			sets an ID to be used as an AJAX reference
		 *		LINK 			=>			makes the cell clickable with the link
		 *		SORTABLE 		=>			only if header - defines how to sort the column: 'letters', 'numbers', 'none'
		 *		FILTERABLE		=>			only if header - defines how to filter the column: 
		 *										'letters', 
		 *										'numbers',
		 *										'none',
		 *										'selection',
		 *										'suggestion'
		 *
		 */
		public function addCell($data, $options) 
		{
			$this->cells[]	= array();
			$i 				= key($this->cells);

			$this->cells[$i]["DATA"] = $data;
			$this->cells[$i]["OPTIONS"] = (array)$options;
		}

		/**
		 * Adds options to the row set
		 * 
		 * @param array 			$options 				Options of the row, see the constructor for more information
		 */
		public function addOptions($options) 
		{
			foreach($options as $key => $option) {
				$this->options[$key] = $option;
			}
		}

		/**
		 * Gets the data of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getCellData($i)
		{
			if($i < $this->getNumberOfColumns() ) {
				return $this->cells[$i]["DATA"];
			}
		}


		/**
		 * Gets the color of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getCellColor($i)
		{
			if(!$this->rowColor) {
				if($i < $this->getNumberOfColumns() ) {
					if( array_key_exists("OPTIONS", $this->cells[$i]) &&
						is_array($this->cells[$i]["OPTIONS"]) &&
						array_key_exists("COLOR"  , $this->cells[$i]["OPTIONS"]) )
							return $this->cells[$i]["OPTIONS"]["COLOR"];
					return null;
				}
			} else {
				return $this->rowColor;
			}		
		}

		/**
		 * Gets the ID of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getCellID($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS", $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("ID"  , $this->cells[$i]["OPTIONS"]) )
						return $this->cells[$i]["OPTIONS"]["ID"];
		}

		
		/**
		 * Gets the link of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getCellLink($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS", $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("LINK"  , $this->cells[$i]["OPTIONS"]) )
						return $this->cells[$i]["OPTIONS"]["LINK"];
		}


		/**
		 * Gets the class of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getCellClass($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS", $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("CLASS"  , $this->cells[$i]["OPTIONS"]) )
						return $this->cells[$i]["OPTIONS"]["CLASS"];
		}

		/**
		 * Gets the colspan of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getCellColspan($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS", $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("COLSPAN"  , $this->cells[$i]["OPTIONS"]) )
						return $this->cells[$i]["OPTIONS"]["COLSPAN"];
		}


		/**
		 * Gets the font color of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getCellFontColor($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS", $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("FONTCOLOR"  , $this->cells[$i]["OPTIONS"]) )
						return $this->cells[$i]["OPTIONS"]["FONTCOLOR"];
		}


		/**
		 * Gets the link of the row
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getSortable($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS"   , $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("SORTABLE", $this->cells[$i]["OPTIONS"]) )
						return $this->cells[$i]["OPTIONS"]["SORTABLE"];
		}

		/**
		 * 
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getFilterable($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS"   , $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("FILTERABLE", $this->cells[$i]["OPTIONS"]) )
						return $this->cells[$i]["OPTIONS"]["FILTERABLE"];
		}

		/**
		 * 
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function isFilterableAuto($i)
		{
			if($i < $this->getNumberOfColumns() )
				if( array_key_exists("OPTIONS"   , $this->cells[$i]) &&
					is_array($this->cells[$i]["OPTIONS"]) &&
					array_key_exists("FILTERABLE", $this->cells[$i]["OPTIONS"]) && 
					array_key_exists("auto", $this->cells[$i]["OPTIONS"]["FILTERABLE"]) )
						return $this->cells[$i]["OPTIONS"]["FILTERABLE"]["auto"];

			return false;
		}


		/**
		 * Gets the ID of the row
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getRowID()
		{
			if($this->options && array_key_exists("ID", $this->options))
				return $this->options["ID"];
		}

		
		/**
		 * Gets the link of the row
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getRowLink()
		{
			if($this->options && array_key_exists("LINK", $this->options))
				return $this->options["LINK"];
		}


		/**
		 * Gets the link of the row
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getRowClass()
		{
			if($this->options && array_key_exists("CLASS", $this->options))
				return $this->options["CLASS"];
		}

		/**
		 * Gets the link of the row
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getRowOnclick()
		{
			if($this->options && array_key_exists("ONCLICK", $this->options))
				return $this->options["ONCLICK"];
		}

		/**
		 * Returns if the table (only header) has stripes
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function hasStripes()
		{
			if($this->options && array_key_exists("HASSTRIPES", $this->options))
				return $this->options["HASSTRIPES"];
			return false;
		}

		/**
		 * Gets the link of the row
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function getRowStripeColor()
		{
			if($this->options && array_key_exists("STRIPECOLOR", $this->options))
				return $this->options["STRIPECOLOR"];
		}
		

		/**
		 * Gets the number of columns
		 */
		public function getNumberOfColumns()
		{
			return count($this->cells);
		}

		
		/**
		 * Sets the color of a specific cell
		 * 
		 * @param int 				$i 						Number of the cell
		 */
		public function setCellColor($i)
		{
			/* TODO */
		}

		/**
		 * Sets the color of the whole row
		 * 
		 * @param string 			$color					Color of the whole row, defined in a CSS standard
		 */
		public function setCellData($i, $data)
		{
			if($i < $this->getNumberOfColumns() )
				$this->cells[$i]["DATA"] = $data;
		}

		
		/**
		 * Sets the color of the whole row
		 * 
		 * @param string 			$color					Color of the whole row, defined in a CSS standard
		 */
		public function setRowColor($color)
		{
			$this->rowColor = $color;
		}


		/**
		 * Sets the color of a stripe on the left side
		 * 
		 * @param string 			$color					Color of the whole row, defined in a CSS standard
		 */
		public function setRowStripeColor($color)
		{
			$this->rowStripeColor = $color;
		}

		

	}