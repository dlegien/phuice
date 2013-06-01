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
	 * A generator for the standard source code of a Gateway,
	 * Repository or Storage.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	types
	 *
	 */
	interface IGatewayGenerator extends ITypeGenerator
	{
		/**
		 * Sets the required class information for the generator. The given namespace will
		 * be prefixed with generated\gateway.
		 * 
		 * @param	string	$gatewayName	The name of the gateway class.
		 * @param	string	$namespace		The namespace of the class.
		 * @param	?		$modelClass		An instance of the model.
		 * @param	array 	$indexes		An array of the indexes.
		 * 
		 * @return	GatewayGenerator		this
		 */		
		public function setClass($gatewayName, $namespace, $modelClass, $indexes = array());
						
		/**
		 * Composes a find by method for the gateway that returns the specified model
		 * with the given return type and requires the provided list of parameters.
		 * 
		 * @param	string	$name			The name of the model.
		 * @param	array 	$parameters		The list of parameters.
		 * @param	string	$returnType		The returntype of the method.
		 * 
		 * @return	Method
		 */
		public function composeFindByMethod($name, $parameters, $returnType);
		
		/**
		 * Composes a find by method for the gateway that returns the specified model
		 * with the given return type and requires the provided list of parameters.
		 * 
		 * @param	string	$name			The name of the model.
		 * @param	array 	$parameters		The list of parameters.
		 * @param	string	$returnType		The returntype of the method.
		 * 
		 * @return	Method
		 */
		public function composeFindAllByMethod($name, $parameters, $returnType);
		
		/**
		 * Returns whether a definition for the given name exists.
		 * 
		 * @param	string	$name	The name of the class.
		 * 
		 * @return	bool
		 */
		public function hasClassDefinition($name);
		
		/**
		 * Returns the class definition for the given name or throws an
		 * InvalidArgumentException if no definition with the name exists.
		 * 
		 * @param	string	$name	The name of the class.
		 * 
		 * @return	ClassDefinition
		 * @throws	InvalidArgumentException If no class definition exists for the given name.
		 */		
		public function getClass($name);
	}