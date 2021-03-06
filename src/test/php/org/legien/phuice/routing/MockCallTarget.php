<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	namespace org\legien\phuice\routing;

	/**
	 * The MockCallTarget accepts calls and reports if it was called.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	routing
	 *
	 */
	class MockCallTarget 
	{
		/**
		 * Whether the target was called.
		 * 
		 * @var boolean
		 */
		private $gotCalled;

		/**
		 * Constructor.
		 */
		public function __construct() 
		{
			$this->gotCalled = FALSE;
		}

		/**
		 * Calls the target.
		 * 
		 * @param mixed $parameter A parameter of the call.
		 */
		public function call($id) 
		{
			if($id == 2) 
			{
				$this->gotCalled = TRUE;
			}
		}
		
		public function withdefault($id, $bla = 3)
		{
			if($id == 2 && $bla == 3)
			{
				$this->gotCalled = TRUE;
			}
		}

		/**
		 * Returns whether the target was called.
		 * 
		 * @return boolean
		 */
		public function gotCalled() 
		{
			return $this->gotCalled;
		}
	}