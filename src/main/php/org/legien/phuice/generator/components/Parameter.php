<?php

	namespace org\legien\phuice\generator\components;
		
	/**
	 * The Parameter class represents a parameter of a class' method.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	components 
	 *
	 */
	class Parameter
	{
		/**
		 * The name of the parameter.
		 *
		 * @var	string
		 */
		private $name;

		/**
		 * The type of the parameter.
		 *
		 * @var	string
		 */
		private $type;

		/**
		 * The default value of the parameter.
		 *
		 * @var	string
		 */
		private $defaultValue;

		/**
		 * The description of the parameter.
		 *
		 * @var	string
		 */
		private $description;


		/**
		 * Constructor for the Parameter class
		 *
		 * @param	string	name			The name of the parameter.
		 * @param	string	type			The type of the parameter.
		 * @param	string	defaultValue	The default value of the parameter.
		 * @param	string	description		The description of the parameter.
		 */
		 public function __construct($name, $type, $defaultValue = NULL, $description = NULL)
		 {
		 	$this->name = $name;
			$this->type = $type;
			$this->defaultValue = $defaultValue;
			$this->description = $description;
		 }
		 
		/**
		 * Sets name to the given value.
		 *
		 * @param	string	name	The name of the parameter.
		 * 
		 * @return	Parameter
		 */
		 public function setName($name)
		 {
		 	$this->name = (string)$name;
			return $this; 
		 }
		 
		/**
		 * Sets type to the given value.
		 *
		 * @param	string	type
		 * 
		 * @return	Parameter
		 */
		 public function setType($type)
		 {
		 	$this->type = (string)$type;
			return $this; 
		 }
		 
		/**
		 * Sets defaultValue to the given value.
		 *
		 * @param	string	defaultValue
		 * 
		 * @return	Parameter
		 */
		 public function setDefaultValue($defaultValue)
		 {
		 	$this->defaultValue = (string)$defaultValue;
			return $this;
		 }
		 
		/**
		 * Sets description to the given value.
		 *
		 * @param	string	description	The description of the parameter.
		 */
		 public function setDescription($description)
		 {
		 	$this->description = (string)$description; 
			return $this;
		 }
		 
		/**
		 * Returns the name of the parameter.
		 *
		 * @return	string
		 */
		 public function getName()
		 {
		 	return (string)$this->name; 
		 }
		 
		/**
		 * Returns the type of the parameter.
		 *
		 * @return	string
		 */
		 public function getType()
		 {
		 	return (string)$this->type; 
		 }
		 
		/**
		 * Returns default value of the parameter.
		 *
		 * @return	string
		 */
		 public function getDefaultValue()
		 {
		 	return (string)$this->defaultValue; 
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
	}