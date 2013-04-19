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

	use org\legien\phuice\logging\Logger;

	/**
	 * An abstract logger that bundles methods useful for all
	 * loggers.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	logging
	 *
	 */
	abstract class AbstractLogger implements Logger 
	{
		/**
		 * The class the logger logs for.
		 * @var string
		 */
		private $clazz;

		/**
		 * Creates a new instance.
		 * 
		 * @param string $clazz	The class the logger logs for.
		 */
		public function __construct($clazz) 
		{
			date_default_timezone_set('UTC');
			$this->clazz = $clazz;
		}

		/**
		 * Returns the class name.
		 * 
		 * @return string
		 */
		protected function getName() 
		{
			return $this->clazz;
		}

		/**
		 * Returns the message string.
		 * 
		 * @param string $type		The logging type.
		 * @param unknown $message	The message.
		 * 
		 * @return string
		 */
		private function getMessage($type, $message) 
		{
			return date('d.m.y H:i:s') . ' ' . $type . ' ' . $this->getName() . ': ' . $message . PHP_EOL;
		}

		/**
		 * Returns the message as a debug message.
		 * 
		 * @param string $message	The message.
		 * 
		 * @return string
		 */
		protected function getDebugMessage($message) 
		{
			return $this->getMessage('DEBUG', $message);
		}

		/**
		 * Returns the message as an error message.
		 * 
		 * @param unknown $message	The message.
		 * 
		 * @return string
		 */
		protected function getErrorMessage($message) 
		{
			return $this->getMessage('ERROR', $message);
		}
	}