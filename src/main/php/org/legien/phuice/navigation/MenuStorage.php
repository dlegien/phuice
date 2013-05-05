<?php

	namespace org\legien\phuice\navigation;

	/**
	 * A storage that holds menu entities.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	navigation
	 *
	 */
	interface MenuStorage 
	{
		/**
		 * Retrieves all menu entries and returns them in
		 * an array.
		 * 
		 * @return array
		 */
		public function findAll();
	}
