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

	namespace org\legien\phuice\logging;

	use org\legien\phuice\logging\AbstractLogger;

	/**
	 * A logger that outputs the messages to the standard output.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	logging
	 *
	 */
	class StdOutLogger extends AbstractLogger 
	{
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\logging\Logger::error()
		 */
		public function error($message) 
		{
			echo $this->getErrorMessage($message);
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\logging\Logger::debug()
		 */
		public function debug($message) 
		{
			echo $this->getDebugMessage($message);
		}
	}