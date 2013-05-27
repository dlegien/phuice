<?php

	namespace org\legien\phuice\generator\components;

	/**
	 * The Method component represents a method of a class.
	 * 
	 * @author		Daniel Legien <d.legien@design-it.de>
	 * @package		org.legien.phuice.generator
	 * @subpackage	components
	 * 
	 */
	class Method
	{
		/**
		 * The name of the method.
		 *
		 * @var	string
		 */
		private $name;

		/**
		 * The parameters of the method.
		 *
		 * @var	array
		 */
		private $parameters;

		/**
		 * The return type of the method.
		 *
		 * @var	string
		 */
		private $returnType;

		/**
		 * The body of the method.
		 *
		 * @var	string
		 */
		private $body;

		/**
		 * The description of the method.
		 *
		 * @var	string
		 */
		private $description;

		/**
		 * Automatically generated field.
		 *
		 * @var	string
		 */
		private $visibility;

		/**
		 * Creates a new Method with the given parameters.
		 * 
		 * @param	string	$name			The name of the method.
		 * @param	array 	$parameters		An array of parameters for the method.
		 * @param	string	$returnType		The return type of the method.
		 * @param	string	$body			The body of the method (i.e. source code)
		 * @param	string	$description	The description of the method.
		 * @param	string	$visibility		The visibility of the method (i.e. private, public, protected).
		 * 
		 */
		public function __construct($name, $parameters = array(), $returnType = NULL, $body = NULL, $description = NULL, $visibility = 'public')
		{
			$this->name = $name;
			$this->parameters = $parameters;
			$this->returnType = $returnType;
			$this->body = $body;
			$this->description = $description;
			$this->visibility = $visibility;
		}

		/**
		 * Sets name to the given value.
		 *
		 * @param	string	name
		 */
		 public function setName($name)
		 {
		 	$this->name = (string)$name; 
		 }
		 
		/**
		 * Sets parameters to the given value.
		 *
		 * @param	array	parameters
		 */
		 public function setParameters($parameters)
		 {
		 	$this->parameters = (array)$parameters; 
		 }
		 
		/**
		 * Sets returnType to the given value.
		 *
		 * @param	string	returnType
		 */
		 public function setReturnType($returnType)
		 {
		 	$this->returnType = (string)$returnType; 
		 }
		 
		/**
		 * Sets body to the given value.
		 *
		 * @param	string	body
		 */
		 public function setBody($body)
		 {
		 	$this->body = (string)$body; 
		 }
		 
		/**
		 * Sets description to the given value.
		 *
		 * @param	string	description
		 */
		 public function setDescription($description)
		 {
		 	$this->description = (string)$description; 
		 }
		 
		/**
		 * Sets visibility to the given value.
		 *
		 * @param	string	visibility
		 */
		 public function setVisibility($visibility)
		 {
		 	$this->visibility = (string)$visibility; 
		 }
		 
		/**
		 * Returns the value of name.
		 *
		 * @return	string
		 */
		 public function getName()
		 {
		 	return (string)$this->name; 
		 }
		 
		/**
		 * Returns the value of parameters.
		 *
		 * @return	array
		 */
		 public function getParameters()
		 {
		 	return (array)$this->parameters; 
		 }
		 
		/**
		 * Returns the value of returnType.
		 *
		 * @return	string
		 */
		 public function getReturnType()
		 {
		 	return (string)$this->returnType; 
		 }
		 
		/**
		 * Returns the value of body.
		 *
		 * @return	string
		 */
		 public function getBody()
		 {
		 	return (string)$this->body; 
		 }
		 
		/**
		 * Returns the value of description.
		 *
		 * @return	string
		 */
		 public function getDescription()
		 {
		 	return (string)$this->description; 
		 }
		 
		/**
		 * Returns the value of visibility.
		 *
		 * @return	string
		 */
		 public function getVisibility()
		 {
		 	return (string)$this->visibility; 
		 }	 
	}