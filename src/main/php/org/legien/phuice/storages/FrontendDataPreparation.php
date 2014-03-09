<?php

	namespace org\legien\phuice\storages;

	use de\holzmayr\fluidmanagement\models\SystemUserSetting;

	/**
	 * This module allows you to prepare data for front end display
	 * 
	 * 
	 * @author		Philipp Pajak
	 * @package		org.legien.phuice
	 * @subpackage	storages
	 *
	 */
	class FrontendDataPreparation
	{
		/**
		 * Name of the data set
		 * 
		 * @var string
		 */
		private $name;

		/**
		 * Number of displayed columns
		 * 
		 * @var integer
		 */
		//private $columns;

		/**
		 * Header row
		 * 
		 * @var FrontendDataPreparationRow
		 */
		private $header;

		/**
		 * Table rows
		 * 
		 * @var array
		 */
		private $rows;

		/**
		 * Results per page
		 * 
		 * @var int
		 */
		private $resultsPerPage;

		/**
		 * An array containing the requested filters
		 * 
		 * @var array
		 */
		private $filters;

		/**
		 * An array containing the requested sorting
		 * 
		 * @var array
		 */
		private $sorting;

		/**
		 * An array containing the available presets
		 * 
		 * @var array
		 */
		private $presets;

		/**
		 * Currently rendered preset
		 * 
		 * @var array
		 */
		private $preset;

		/**
		 * Is the request processed?
		 * 
		 * @var bool
		 */
		private $loaded;


		/**
		 * Constructor.
		 * 
		 * @param string						$name 			The name of the data set.
		 * @param FrontendDataPreparationRow	$header			The header of the data set(optional).
		 * @param array							$rows			Data set rows (optional).
		 */
		public function __construct($name, FrontendDataPreparationRow $header = null, $rows = null)
		{
			$this->name = $name;

			if($header)
				$this->header = $header;

			if($rows)
				$this->rows   = $rows;

			$this->loaded = false;

			$this->dateFormats = array(
				'Y-m-d',
				'Y-m-d H:i',
				'Y-m-d H:i:s',
				'd.m.Y',
				'd.m.Y H:i',
				'd.m.Y H:i:s',
				'm/Y',
				'd/m'
				);
		}

		/**
		 * Sets the data set header
		 * 
		 * @param FrontendDataPreparationRow
		 */
		public function setHeader(FrontendDataPreparationRow $row) {
			$this->header = $row;
		}

		/**
		 * Adds a row to the table
		 * 
		 * @param FrontendDataPreparationRow
		 */
		public function addRow($row) {
			$this->rows[] = $row;
			end($this->rows);
			return(key($this->rows));
		}

		/**
		 * Adds rows to the table
		 * 
		 * @param array
		 */
		public function addRows($rows) {
			if(is_array($rows)) {
				foreach($rows as $row) 
					$this->addRow($row);
			} else {
				$this->addRow($rows);
			}
		}

		/**
		 * Removes the last row that was added
		 * 
		 * @param FrontendDataPreparationRow
		 */
		public function removeLastRow() {
			return array_pop($this->rows);
		}

		/**
		 * Gets the name of the data set
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * Gets the header of the data set
		 */
		public function getHeader() {
			return $this->header;
		}

		/**
		 * Gets a row from the data set
		 * 
		 * @param int
		 */
		public function getRow($i) {
			return $this->rows[$i];
		}

		/**
		 * Get custom filters
		 * 
		 */
		public function getCustomFilters() {
			$customFilters = array();

			if($this->filters)
				foreach($this->filters as $filter) {
					if(array_key_exists("custom", $filter))
						$customFilters[] = $filter;
				}

			return $customFilters;
		}

		/**
		 * Remove custom filters
		 * 		!! this will break saving custom filters !!
		 */
		public function removeCustomFilters() {
			if($this->filters)
				foreach($this->filters as $key => $filter) {
					if(array_key_exists("custom", $filter))
						unset($this->filters[$key]);
				}
		}

		/**
		 * Set a flag to ignore custom filters by the filtering engine
		 * 
		 */
		public function ignoreCustomFilters() {
			$this->ignoreCustomFilters = true;
		}

		/**
		 * Create an array of a column
		 * 
		 * @param int
		 */
		private function createColumnArray($i) {
			$column = array();
			if( count($this->rows) > 0)
				foreach($this->rows as $key => $row) {
					$column[$key] = $row->getCellData($i);
				}
			return $column;
		}

		/**
		 * Rearrange the internal rows by a column array
		 * 
		 * @param array
		 */
		private function rearrangeRowsByColumnArray($column){
			//rearange rows array by sorted column
			$newRows = array();
			foreach($column as $key => $rowData) {
				$newRows[] = $this->rows[$key];
			}

			unset($this->rows);
			$this->rows = $newRows;
		}

		/**
		 * Sorts the data set by a specific column
		 * 
		 * @param int
		 */
		public function sortByColumn($i, $direction = "ASC") {	
			$column = $this->createColumnArray($i);

			//check is date
			if( isset($column[0]) && $this->isDate($column[0]) )
				foreach($column as $key => $val)
					$column[$key] = strtotime($val);

			switch($direction) {
				case "ASC":
					asort($column);
					break;
				case "DESC":
					arsort($column);
					break;
				default:
					//if sorting direction is not readable just assume ascending
					asort($column);
					break;
			}


			
			$this->rearrangeRowsByColumnArray($column);
		}

		private function isDate($str) {
			foreach($this->dateFormats as $format) {
				$date = \DateTime::createFromFormat($format, $str);

				if($date == true && date_format($date,$format) == $str)
					return true;
			}
			return false;
		}

		private function isHTML($str) {
			//check for html opening tag
			if( $pos = stripos($str, "<") === false )
				return false;
			//check for html closing tag
			if( stripos($str, ">", $pos) === false )
				return false;
			return true;
		}

		/**
		 * Filters the data set by... ? 
		 * 
		 * @param array
		 */
		public function filterBy($col, $cmp, $val) {
			if( $col >= $this->header->getNumberOfColumns())
				return false;

			$column = $this->createColumnArray($col);

			//watch out..dirty
				//check if is string comparison but field contains html
			if( $cmp == "=" && isset($column[0]) && $this->isHTML($column[0]) )
				$cmp = "contains";

			foreach($column as $key => $value) {
				switch($cmp) {
					case ">":
						if(! ($value > $val))
							unset($column[$key]);
						break;
					case "<":
						if(! ($value < $val))
							unset($column[$key]);
						break;
					case "=":
						if(is_string($val) || is_string($value)) {
							if( strcasecmp( $val, $value) != 0 )
								unset($column[$key]);
						} else {
							if(! ($value == $val))
								unset($column[$key]);	
						}
						break;
					case "contains":
						if( stripos($value, $val) === false )
							unset($column[$key]);
						break;
					case "between":
						$times = explode("|", $val);
						$fromTime = $times[0] ? : 0;
						$untilTime = $times[1] ? : 0;

						if( (strtotime($fromTime) > strtotime($value)) ||
						    ($untilTime > 0 && (strtotime($untilTime) < strtotime($value))) )
							unset($column[$key]);
						break;
					case "none":

						break;
				}
			}

			$this->rearrangeRowsByColumnArray($column);
		}

		/**
		 * Sets the showed results per page
		 * 
		 * @param int
		 */
		public function setResultsPerPage($resultsPerPage) {
			$this->resultsPerPage = $resultsPerPage;
		}

		/**
		 * Gets the data set as JSON array
		 * 
		 * @param int
		 */
		public function getDataSet( $page = 0 ) {
			/* TODO */

			$dataSet 		= array();
			$columns 		= $this->header->getNumberOfColumns();
			$columnColors 	= array();

			if(!$this->resultsPerPage) {
				$this->resultsPerPage = count($this->rows);
			}

			if( count($this->rows) > 0 ) {
				$pages = (int) floor( count($this->rows) / $this->resultsPerPage ) 
							- 
						 ( ((count($this->rows) % $this->resultsPerPage) == 0)? 1 : 0 );
			} else {
				$pages = 0;
			}

			//generate information header
			$dataSet[] = array(
				"ROWS"				=> count($this->rows),
				"PAGES"				=> $pages,
				"FILTERS"			=> $this->filters,
				"SORTING"			=> $this->sorting,
				"RESULTSPERPAGE"	=> $this->resultsPerPage,
				"PRESETS"			=> $this->presets,
				"PRESET"			=> $this->preset,
				"HASSTRIPES" 		=> $this->header->hasStripes()
			);

			//generate header
			$headerRow 		= array();

			for($i = 0; $i < $columns; $i++) {
				$cellColor = null;

				if( $cellColor = $this->header->getCellColor($i) ) {
					$columnColors[$i] = $cellColor;
				}

				$thisCell = array();

				$thisCell["DATA"] 		= $this->header->getCellData($i);
				$thisCell["COLOR"]		= $cellColor;
				$thisCell["SORTABLE"] 	= $this->header->getSortable($i);
				$thisCell["FILTERABLE"] = $this->header->getFilterable($i);
				$thisCell["CLASS"] 		= $this->header->getCellClass($i);
				$thisCell["COLSPAN"]	= $this->header->getCellColspan($i);

				if($thisCell["COLSPAN"] && $thisCell["COLSPAN"] > 1)
						$i++;

				$headerRow[$i] = $thisCell;
			}
			$dataSet[] = $headerRow;

			//generate body
			$i 		 = $this->resultsPerPage * $page;
			$lastRow = $i + $this->resultsPerPage;

			if($lastRow > count($this->rows))
				$lastRow = count($this->rows);


			while($i < $lastRow) {
				$thisRow			= array();
				$thisRow["OPTIONS"] = array(
					"ID" 			=> $this->getRow($i)->getRowID(),
					"LINK" 			=> $this->getRow($i)->getRowLink(),
					"CLASS" 		=> $this->getRow($i)->getRowClass(),
					"ONCLICK"		=> $this->getRow($i)->getRowOnclick(),
					"STRIPECOLOR" 	=> $this->getRow($i)->getRowStripeColor()
				);

				$thisRow["DATA"] 	= array();
	
				for($j = 0; $j < $columns; $j++) {
					$thisCell			= array();

					$thisCell["DATA"]		= $this->getRow($i)->getCellData($j);
					$thisCell["ID"]			= $this->getRow($i)->getCellID($j);
					$thisCell["LINK"]		= $this->getRow($i)->getCellLink($j);
					$thisCell["CLASS"]		= $this->getRow($i)->getCellClass($j);
					$thisCell["COLSPAN"]	= $this->getRow($i)->getCellColspan($j);
					$thisCell["FONTCOLOR"]	= $this->getRow($i)->getCellFontColor($j);

					if( array_key_exists($j, $columnColors)) {
						$thisCell["COLOR"] = $columnColors[$j];	
					} else {
						$thisCell["COLOR"] = $this->getRow($i)->getCellColor($j);
					}

					//remove empty values from cell
					$thisRow["DATA"][]		= array_filter($thisCell, 'strlen');

					#automatic data completion?
					if($this->header->isFilterableAuto($j))
						$dataSet[1][$j]["FILTERABLE"]["values"][] = $thisCell["DATA"];

					if($thisCell["COLSPAN"] && $thisCell["COLSPAN"] > 1)
						$j++;
				}
				$dataSet[] = $thisRow;

				$i++;
			}

			#remove double values for automatic data completion
			for($i=0; $i<$columns;$i++) {
				if($this->header->isFilterableAuto($i))
					if( array_key_exists($i, $dataSet[1]) &&
						array_key_exists("FILTERABLE", $dataSet[1][$i]) &&
						array_key_exists("values", $dataSet[1][$i]["FILTERABLE"]))
					$dataSet[1][$i]["FILTERABLE"]["values"] = array_unique($dataSet[1][$i]["FILTERABLE"]["values"]);
			}
			return $dataSet;
		}

		private function deletePreset( $controller, $preset ) {
			$controller->setSystemUserSetting('FDP_'.$this->name.'_'.$preset.'_filter', null);
			$controller->setSystemUserSetting('FDP_'.$this->name.'_'.$preset.'_sorting', null);
			$controller->setSystemUserSetting('FDP_'.$this->name.'_'.$preset.'_resultsPerPage', null);

			if(($key = array_search($preset, $this->presets)) !== false)
				unset($this->presets[$key]);

			$this->savePresets($controller);
		}

		private function savePresets( $controller ) {
			$this->presets = array_values($this->presets);
			sort($this->presets);
			$controller->setSystemUserSetting('FDP_'.$this->name.'_presets', json_encode($this->presets));
		}

		public function load( $request, $controller ) {
			//unpack request
			$resultsPerPage = $request->getParameter('resultsPerPage');
			$this->page		= $request->getParameter('page') 			?: 0;
			$this->sorting	= $request->getParameter('sorting');
			$this->filters 	= $request->getParameter('filter');
			$this->preset	= $request->getParameter('preset') 			?: 'default';
			$savePreset		= $request->getParameter('savePreset') 		?: false;
			$loadPreset		= $request->getParameter('loadPreset') 		?: false;
			$deletePreset	= $request->getParameter('deletePreset') 	?: false;
			$newPresetName  = $request->getParameter('newPresetName') 	?: false;

			$this->presets = json_decode($controller->getSystemUserSetting('FDP_'.$this->name.'_presets'), true);

			if($newPresetName) {
				$this->deletePreset($controller, $this->preset);
				$this->preset = $newPresetName;
			}

			if($deletePreset) {
				$this->deletePreset($controller, $this->preset);
				die("OK");
			}

			if($savePreset && $savePreset != "false") {
				//save the filter and sortings, so we can use it for future requests
				if($this->filters)
					$controller->setSystemUserSetting('FDP_'.$this->name.'_'.$this->preset.'_filter', json_encode($this->filters));
				if($this->sorting)
					$controller->setSystemUserSetting('FDP_'.$this->name.'_'.$this->preset.'_sorting', json_encode($this->sorting));
				if($resultsPerPage)
					$controller->setSystemUserSetting('FDP_'.$this->name.'_'.$this->preset.'_resultsPerPage', $resultsPerPage);

				//is this preset already registered in the system?
				if( !is_array($this->presets) || !in_array($this->preset, $this->presets)) {
					$this->presets[] = $this->preset;
					$this->savePresets($controller);
				}

			} else if ($loadPreset && $loadPreset != "false") {
				//user does not want to save the preset, so lets try to fetch it!
				//if(!$this->filters)
					$this->filters = json_decode( 
						$controller->getSystemUserSetting('FDP_'.$this->name.'_'.$this->preset.'_filter'),true);

				//if(!$this->sorting)
					$this->sorting = json_decode( 
						$controller->getSystemUserSetting('FDP_'.$this->name.'_'.$this->preset.'_sorting'),true);

				$resultsPerPage =
					$controller->getSystemUserSetting('FDP_'.$this->name.'_'.$this->preset.'_resultsPerPage')?: $resultsPerPage;
			}

			if($resultsPerPage > 0)
				$this->setResultsPerPage($resultsPerPage);

			if($this->page < 0) {
				$this->page = 0;
			}

			$this->loaded = true;
		}

		/**
		 * Render the table as csv
		 *
		 * @param request
		 */
		private function getCSVDataSet($exportOptions = array()) {
			$nl = "\n";
			$dl = ";";
			$csv = "";

			$columns = $this->header->getNumberOfColumns();
			$rows 	 = count($this->rows);

			#header
			for($col=0;$col<$columns;$col++)
				$csv .= $this->html2txt($this->header->getCellData($col)) . $dl;
			$csv .= $nl;

			#rows
			if($rows > 0)
				foreach($this->rows as $i => $row) {
					for($col=0;$col<$columns;$col++)
						$csv .= $this->html2txt($row->getCellData($col)) . $dl;
					$csv .= $nl;
				}

			if(isset($exportOptions["filename"]))
				$filename = $exportOptions["filename"];
			else
				$filename = "export.csv";

			header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename='.$filename.'.csv');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
			echo utf8_decode($csv);
			die("");
		}

		function html2txt($document){ 
			$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript 
			               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags 
			               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly 
			               '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA 
			); 
			$text = preg_replace($search, '', $document); 
			return $text; 
		}

		/**
		 * Render the table to JSON/CSV in the current view
		 * 
		 * @param request
		 */
		public function render( $request, $controller, $exportType = 'JSON', $exportOptions = array() ) {
			if(!$this->loaded) {
				$this->load($request, $controller);
			}

			if($this->filters)
				foreach($this->filters as $filter)
					if($filter['value'] != 'noFilter' && !(isset($this->ignoreCustomFilters) && isset($filter['custom'])) )
						$this->filterBy		( $filter['column'] , $filter['compare']    , $filter['value']);
			if($this->sorting)
				$this->sortByColumn	( $this->sorting['column'], $this->sorting['direction']);

			if($request->getParameter('exportType'))
				$exportType = $request->getParameter('exportType');

			if($request->getParameter('exportFilename'))
				$exportOptions["filename"] = $request->getParameter('exportFilename');

			switch($exportType) {
				case "JSON":
					return $this->getDataSet($this->page);
					break;
				case "CSV":
					return $this->getCSVDataSet($exportOptions);
					break;
				default:
					return $this->getDataSet($this->page);
					break;
			}
			
		}

	}