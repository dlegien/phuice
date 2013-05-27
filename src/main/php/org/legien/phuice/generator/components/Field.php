<?php

	namespace org\legien\phuice\generator\components;
	
	/**
	 * The Field class represents a field of a class. 
	 *
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	components
	 * 
	 */
	class Field
	{
		/**
		 * The name of the field.
		 *
		 * @var	string
		 */		
		private $name;

		/**
		 * The visibility of the field.
		 *
		 * @var	string
		 */
		private $visibility;

		/**
		 * The type of the field.
		 *
		 * @var	string
		 */
		private $type;

		/**
		 * The description of the field.
		 *
		 * @var	string
		 */
		private $description;
			 
		/**
		 * The default value of the field.
		 *
		 * @var mixed
		 */
		private $defaultValue;


		/**
		 * Constructor of the ClassDefinition class.
		 *
		 * @param	string	name	
		 * @param	string	type	
		 * @param	string	description	
		 * @param	string	visibility	
		 */
		 public function __construct($name, $type, $description = '', $visibility = 'private', $defaultValue = NULL)
		 {
		 	$this->name = $name;
			$this->type = $type;
			$this->description = $description;
			$this->visibility = $visibility;
			$this->defaultValue = $defaultValue;	 
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
		 * Sets visibility to the given value.
		 *
		 * @param	string	visibility	
		 */
		 public function setVisibility($visibility)
		 {
		 	$this->visibility = (string)$visibility; 
		 }
		 
		/**
		 * Sets type to the given value.
		 *
		 * @param	string	type	
		 */
		 public function setType($type)
		 {
		 	$this->type = (string)$type; 
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
		 * Returns the value of name.
		 *
		 * @return	string
		 */
		 public function getName()
		 {
		 	return (string)$this->name; 
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
		 
		/**
		 * Returns the value of type.
		 *
		 * @return	string
		 */
		 public function getType()
		 {
		 	return (string)$this->type; 
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
		  * Sets the default value of the field
		  * 
		  * @param	string	$defaultValue	The default value of the field.
		  * 	
		  */
		 public function setDefaultValue($defaultValue)
		 {
		 	$this->defaultValue = $defaultValue;
			return $this;
		 }
		 
		 /**
		  * Returns the field's default value as a number if it is
		  * numeric, quoted in single quotes if it is not null or
		  * null otherwise.
		  * 
		  * @return	mixed
		  */
		 public function getDefaultValue()
		 {
		 	if(is_numeric($this->defaultValue))
			{
		 		return ' = ' . $this->defaultValue;
			}
			elseif(!is_null($this->defaultValue))
			{
				return " = '" . $this->defaultValue ."'";
			}
			return NULL;
		 }
	}