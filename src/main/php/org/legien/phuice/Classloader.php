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

	namespace org\legien\phuice;

	use org\legien\phuice\exceptions\ClassNotFoundException;

	/**
	 * A singleton class loader that allows the registration of
	 * additional class loaders through closures.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice
	 *
	 */
	class Classloader 
	{
		/**
		 * The instance of the singleton.
		 * @var Classloader
		 */
		private static $_instance = NULL;

		/**
		 * The registered loaders.
		 * @var array
		 */
		protected $_loaders = array();

		/**
		 * Creates a new instance that registers itself as
		 * an auto loader.
		 */
		private function __construct() 
		{
			spl_autoload_register(array($this, 'loader'));
		}

		/**
		 * Sets a loader with the given name and code.
		 * 
		 * @param string $name	The name.
		 * @param unknown $code	The code.
		 */
		protected function setPathClosure($name, $code) 
		{
			$this->_loaders[$name] = $code;
		}

		/**
		 * Add an array of loaders.
		 * 
		 * @param array $loaders	The loaders to add.
		 */
		public function addLoaders($loaders = array()) 
		{
			foreach((array) $loaders as $key => $value) 
			{
				$this->setPathClosure($key, $value);
			}
		}

		/**
		 * Returns an instance and creates it if does not exist
		 * yet.
		 * 
		 * @return Classloader
		 */
		public function getInstance() 
		{
			if(is_null(self::$_instance)) 
			{
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Tries to resolve the given class name using it's registered
		 * loaders.
		 * 
		 * @param string $className	The class name.
		 * 
		 * @throws ClassNotFoundException	If the class could not be resolved.
		 */
		protected function loader($className) 
		{
			foreach($this->_loaders as $value) 
			{
				$filename = $value($className);
				if(is_readable($filename)) 
				{
					include_once($filename);
					break;
				}
			}

			if(class_exists($className, FALSE) === FALSE && interface_exists($className, FALSE) === FALSE) 
			{
				throw new ClassNotFoundException('Class ' . $className . ' could not be loaded.');
			}
		}
	}
