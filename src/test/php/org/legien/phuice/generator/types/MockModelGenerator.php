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

	namespace org\legien\phuice\generator\types;

	use org\legien\phuice\generator\types\IModelGenerator;

	/**
	 * A model generator for testing.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	types
	 *
	 */
	class MockModelGenerator implements IModelGenerator
	{
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\generator\types\IModelGenerator::setClass()
		 */
		public function setClass($modelName, $namespace, $fields = array())
		{
			echo __METHOD__ . PHP_EOL;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\generator\types\IModelGenerator::getClass()
		 */
		public function getClass($name)
		{
			echo __METHOD__ . PHP_EOL;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\generator\types\ITypeGenerator::generate()
		 */
		public function generate($name)
		{
			echo __METHOD__ . PHP_EOL;			
		}
	}