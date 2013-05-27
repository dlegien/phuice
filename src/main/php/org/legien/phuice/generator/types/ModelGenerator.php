<?php

	namespace org\legien\phuice\generator\types;
	
	use org\legien\phuice\generator\components\ClassDefinition;
	use org\legien\phuice\generator\components\Field;
	use org\legien\phuice\generator\components\Method;
	use org\legien\phuice\generator\components\Parameter;
	use org\legien\phuice\generator\languages\LanguageGeneratorInterface;
	
	/**
	 * The ModelGenerator defines all the fields and methods required by
	 * a standard model. It uses a language specific generator to
	 * generate the actual source code.
	 * 
	 * @author		Daniel Legien
	 * 				Rüdiger Willmann <r.willmann@design-it.de>
	 * @package		org.legien.phuice.generator
	 * @subpackage	types
	 *  
	 */		
	class ModelGenerator implements IModelGenerator
	{
		/**
		 * The generator that is used to create the actual
		 * source code.
		 *
		 * @var LanguageGeneratorInterface
		 */		
		private $generator;
			
		/**
		 * An array holding all existing model definitions
		 * in this generator.
		 *
		 * @var	array
		 */
		private $classes = array();
		
		/**
		 * Creates a new ModelGenerator that uses the given language generator
		 * to generate the source code.
		 * 
		 * @param	LanguageGeneratorInterface	$generator	The generator for the source code.
		 * 
		 * @return	void
		 */
		public function __construct(LanguageGeneratorInterface $generator)
		{
			$this->generator = $generator;
		}
		
		/**
		 * Composes a new field with the given name and type and also adds a standard
		 * description and private visibility.
		 * 
		 * @param	string	$name	The name of the field.
		 * @param	string	$type	The type of the field.
		 * 
		 * @return	Field
		 */
		private function composeField($name, $type)
		{
			return new Field(
				$name, 
				$type, 
				"Automatically generated field.",
				'private'
			);
		}
		
		/**
		 * Creates a class definition from the given parameters.
		 * 
		 * @param	string	$modelName	The name of the model.
		 * @param	string	$namespace	The namespace of the model.
		 * @param	array 	$fields		The fields of the model.
		 * 
		 * @return	ModelGenerator		this
		 */
		public function setClass($modelName, $namespace, $fields = array())
		{
			// Create the class with the base attributes
			$class = new ClassDefinition($modelName, $namespace);
			
			// Add optional attributes to the class definition
			$class
				->setDescription("An automatically generated model class for $modelName.")
				->setAuthor('Generator')
			;
			
			// Loop over the fields
			foreach($fields as $name => $type)
			{
				// Compose the fields and set getter and setter
				$class
					->setField($this->composeField($name, $type))
					->setGetter($name)
					->setSetter($name)
				;				
			}

			// Compose the constructor
			//$class->setMethod($this->composeConstructor());

			// Compose the toArray method
			$class->setMethod($this->composeToArrayMethod());
			
			// Save the definition for later use
			$this->classes[$modelName] = $class;
			
			return $this;			
		}
		
		/**
		 * Composes the toArray method.
		 * 
		 * @return	string
		 */
		private function composeToArrayMethod()
		{
			return new Method(
				'toArray', 
				array(), 
				'array', 
				'$return = array();' . PHP_EOL . 'foreach(array_keys(get_class_vars(__CLASS__)) as $field)
{
	$return[strtoupper($field)] = $this->$field;
}
return $return;
', 
					'Returns an array representation of the model.'
				);
			
		}
		
		/**
		 * Composes constructor.
		 * 
		 * @return	string
		 */
		private function composeConstructor()
		{
			return new Method(
				'__construct', 
				array(
					new Parameter('initialData', 'array', 'array()', 'Array containing initial data.')
				), 
				'void', 
				'foreach($initialData as $key => $value) { $this->$key = $value; }',
				'',
				'public'
				);
		}
		
		/**
		 * Returns the model definition with the given name.
		 * 
		 * @param	string	$name	The name of the model.
		 * 
		 * @return	ClassDefinition  
		 */
		public function getClass($name)
		{
			return $this->classes[$name];
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\generator\types\ITypeGenerator::generate()
		 */
		public function generate($name)
		{
			return $this->generator->generate($this->classes[$name]);
		}
	}
	