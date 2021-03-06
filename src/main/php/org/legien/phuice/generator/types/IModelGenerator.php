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
	
	/**
	 * A generator for standard code for models.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	types
	 *
	 */
	interface IModelGenerator extends ITypeGenerator
	{	
		/**
		 * Creates a class definition from the given parameters.
		 * 
		 * @param	string	$modelName	The name of the model.
		 * @param	string	$namespace	The namespace of the model.
		 * @param	array 	$fields		The fields of the model.
		 * 
		 * @return	ModelGenerator		this
		 */
		public function setClass($modelName, $namespace, $fields = array());
		
		/**
		 * Returns the model definition with the given name.
		 * 
		 * @param	string	$name	The name of the model.
		 * 
		 * @return	ClassDefinition  
		 */
		public function getClass($name);
	}