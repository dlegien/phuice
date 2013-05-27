<?php

	namespace org\legien\phuice\generator\components;
	
	/**
	 * The ClassDefinition class represents a class with all it's
	 * attributes.
	 *
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	components
	 * 
	 */
	class ClassDefinition
	{
		/**
		 * The name of the class.
		 *
		 * @var	string
		 */
		private $name;
		
		/**
		 * The namespace of the class.
		 *
		 * @var	string
		 */
		private $namespace;

		/**
		 * Whether the class is abstract or not.
		 *
		 * @var	bool
		 */
		private $abstract;

		/**
		 * The name of the author.
		 *
		 * @var	string
		 */
		private $author;

		/**
		 * The description of the class.
		 *
		 * @var	string
		 */
		private $description;

		/**
		 * The methods of the class.
		 *
		 * @var	array
		 */
		private $methods;

		/**
		 * The fields of the class.
		 *
		 * @var	array
		 */
		private $fields;

		/**
		 * The setters of the class.
		 *
		 * @var	array
		 */
		private $setters;

		/**
		 * The getters of the class.
		 *
		 * @var	array
		 */
		private $getters;

		/**
		 * The classes the class extends.
		 *
		 * @var	array
		 */
		private $extends;

		/**
		 * The interfaces the class implements.
		 *
		 * @var	array
		 */
		private $implements;
			 
		/**
		 * The dependencies of the class.
		 *
		 * @var array
		 */
		private $dependencies;

		/**
		 * Constructor of the ClassDefinition class.
		 *
		 * @param	string	name		The name of the class.
		 * @param	string	namespace	The namespace of the class.
		 * @param	array	extends		A list of classes this class extends.
		 * @param	array	implements	A list of interfaces this class implements.
		 */
		 public function __construct($name, $namespace, $extends = array(), $implements = array())
		 {
		 	$this->name = $name;
			$this->namespace = $namespace;
			$this->extends = $extends;
			$this->implements = $implements; 
			$this->setters = array();
			$this->getters = array();
			$this->dependencies = array();
		 }
		 
		/**
		 * Sets a method of the class.
		 *
		 * @param	Method	method	
		 */
		 public function setMethod($method)
		 {
		 	$this->methods[] = $method; 
			return $this;
		 }
		 
		/**
		 * Sets a field of the class.
		 *
		 * @param	Field	field	
		 */
		 public function setField($field)
		 {
		 	$this->fields[$field->getVisibility()][] = $field;
			return $this;			 
		 }
		 
		/**
		 * Adds a setter to the class.
		 *
		 * @param	string	name	
		 */
		 public function setSetter($name)
		 {
		 	$this->setters[$name] = TRUE;
			return $this;			 
		 }
		 
		/**
		 * Adds a getter to the class.
		 *
		 * @param	string	name	
		 */
		 public function setGetter($name)
		 {
		 	$this->getters[$name] = TRUE;
			return $this;			 
		 }
		 
		/**
		 * Sets name to the given value.
		 *
		 * @param	string	name	
		 */
		 public function setName($name)
		 {
		 	$this->name = (string)$name;
			return $this;			 
		 }
		 
		/**
		 * Sets namespace to the given value.
		 *
		 * @param	string	namespace	
		 */
		 public function setNamespace($namespace)
		 {
		 	$this->namespace = (string)$namespace;
			return $this;			 
		 }
		 
		/**
		 * Sets abstract to the given value.
		 *
		 * @param	bool	abstract	
		 */
		 public function setAbstract($abstract = TRUE)
		 {
		 	$this->abstract = (bool)$abstract;
			return $this;			 
		 }
		 
		/**
		 * Sets author to the given value.
		 *
		 * @param	string	author	
		 */
		 public function setAuthor($author)
		 {
		 	$this->author = (string)$author; 
			return $this;			
		 }
		 
		/**
		 * Sets description to the given value.
		 *
		 * @param	string	description	
		 */
		 public function setDescription($description)
		 {
		 	$this->description = (string)$description;
			return $this;			 
		 }
		 
		/**
		 * Sets extends to the given value.
		 *
		 * @param	array	extends	
		 */
		 public function setExtends($extends)
		 {
		 	$this->extends = (array)$extends;
			return $this;			 
		 }
		 
		/**
		 * Sets implements to the given value.
		 *
		 * @param	array	implements	
		 */
		 public function setImplements($implements)
		 {
		 	$this->implements = (array)$implements;
			return $this;			 
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
		 * Returns the full qualified name of the class.
		 *
		 * @return	string
		 */
		 public function getFullQualifiedName()
		 {
		 	return
		 		$this->getNamespace()
		 		. (
		 			strlen($this->getNamespace())
		 			? '\\'
					: ''
				)
		 		. $this->getName()
			;
		 }
		 
		/**
		 * Returns the value of namespace.
		 *
		 * @return	string
		 */
		 public function getNamespace()
		 {
		 	return (string)$this->namespace; 
		 }
		 
		/**
		 * Returns the value of abstract.
		 *
		 * @return	bool
		 */
		 public function getAbstract()
		 {
		 	return (bool)$this->abstract; 
		 }
		 
		/**
		 * Returns the value of author.
		 *
		 * @return	string
		 */
		 public function getAuthor()
		 {
		 	return (string)$this->author; 
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
		 * Returns the value of extends.
		 *
		 * @return	array
		 */
		 public function getExtends()
		 {
		 	return (array)$this->extends; 
		 }
		 
		/**
		 * Returns the value of implements.
		 *
		 * @return	array
		 */
		 public function getImplements()
		 {
		 	return (array)$this->implements; 
		 }
		 
		 /**
		  * Returns all the fields.
		  * 
		  * @return	array
		  */
		 public function getFields()
		 {
		 	return (array)$this->fields;
		 }
		 
		 /**
		  * Returns whether a setter is required for the field with
		  * the specified name.
		  * 
		  * @return	bool
		  */
		 public function hasSetter($name)
		 {
		 	return key_exists($name, $this->setters);
		 }
		 
		 /**
		  * Returns whether a getter is required for the field with
		  * the specified name.
		  * 
		  * @return	bool
		  */
		 public function hasGetter($name)
		 {
		 	return key_exists($name, $this->getters);
		 }
		 
		 /**
		  * Returns the defined methods of the class.
		  * 
		  * @return	array
		  */
		 public function getMethods()
		 {
		 	return (array)$this->methods;
		 }
		 
		 /**
		  * Sets a dependency for the class.
		  * 
		  * @param	Dependency	$dependency	The dependency of the class.
		  * 
		  */
		 public function setDependency($depedency)
		 {
		 	$this->dependencies[] = $depedency;
			return $this;
		 }
		 
		 /**
		  * Returns an array with all dependencies of the class.
		  * 
		  * @return	array
		  */
		 public function getDependencies()
		 {
		 	return $this->dependencies;
		 }
	}