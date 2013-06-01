<?php

	namespace org\legien\phuice\generator\converters;
	
	use org\legien\phuice\generator\components\ClassDefinition;
	use org\legien\phuice\generator\components\Parameter;
	use org\legien\phuice\generator\components\Field;
	use org\legien\phuice\generator\components\Method;
	
	use org\legien\phuice\generator\converters\ConverterInterface;

	/**
	 * A converter that converts an XML string into a class definition.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	converters
	 * 
	 */
	class XMLConverter implements ConverterInterface
	{
		/**
		 * Converts the XML data into a class definition.
		 * 
		 * @param	string	$xml	The xml data.
		 * 
		 * @return	ClassDefinition
		 */	
		public function convert($xml)
		{
			try 
			{
				$sources = array();
				$xml = new \SimpleXMLElement($xml);
					
				foreach($xml->class as $class)
				{
					$sources[] = $this->convertClass($class);
				}
				
				return $sources;				
			}
			catch (\Exception $e)
			{
				throw new ConverterException($e->getMessage());
			}
		}

		/**
		 * Converts an xml class representation to a class definition object.
		 * 
		 * @param	SimpleXMLElement	$class 	The xml representation of the class.
		 * 
		 * @return	ClassDefinition
		 */
		private function convertClass($class)
		{
			// Set the class and its basic attributes
			$classDef = new ClassDefinition((string)$class['name'], (string)$class['namespace']);
			
			// Set optional attributes of the class
			$classDef
				->setAbstract(($class['isAbstract'] == 'true' ? TRUE : FALSE))
				->setAuthor($class['author'])
				->setDescription(str_replace('\n', "\n", $class['description']))
			;
			
			if ($class['extends']) {
				$classDef->setExtends(array($class['extends']));
			}
			
			// Loop over the fields.	
			foreach($class->fields->field as $field)
			{
				// Set the field
				$classDef->setField($this->convertField($field));
				
				// Check if we want setters
				if($field['setter'] == 'true')
				{
					$classDef->setSetter((string)$field['name']);
				}
				
				// Check if we want getters
				if($field['getter'] == 'true')
				{
					$classDef->setGetter((string)$field['name']);
				}				
			}
				
			foreach($class->methods->method as $method)
			{				
				$classDef->setMethod(
					$this->convertMethod(
						$method, 
						$this->convertParameters(
							$method->parameters->parameter
						)
					)
				);
			}
				
			return $classDef;			
		}
		
		/**
		 * Converts a list of xml parameters to an array of parameter
		 * objects.
		 * 
		 * @param	SimpleXMLElement 	$parameters	The xml list of parameters.
		 * 
		 * @return	array
		 */
		private function convertParameters($parameters)
		{
			$params = array();
			foreach($parameters as $parameter)
			{
				$params[] = $this->convertParameter($parameter);
			}
			return $params;			
		}
		
		/**
		 * Converts an xml parameter to a parameter object.
		 * 
		 * @param	SimpleXMLElement	$parameter	The xml representation of the parameter.
		 * 
		 * @return	Parameter
		 */
		private function convertParameter($parameter)
		{
			return new Parameter(
				$parameter['name'], 
				$parameter['type'], 
				$parameter['defaultValue'], 
				$parameter['description']
			);			
		}
		
		/**
		 * Converts an xml field representation to a field object.
		 * 
		 * @param	SimpleXMLElement	$field	The xml representation of the field.
		 * 
		 * @return	Field
		 */
		private function convertField($field)
		{
			return new Field(
				(string)$field['name'], 
				(string)$field['type'], 
				(string)$field['description'],
				(string)$field['visibility']						
			);			
		}
		
		/**
		 * Converts an xml method representation to a method
		 * object.
		 * 
		 * @param	SimpleXMLElement	$method		The xml representation of the method.
		 * @param	array 				$parameters	An array of parameter objects.
		 * 
		 * @return	Method
		 */
		private function convertMethod($method, $parameters)
		{
			return new Method(
				(string)$method['name'], 
				$parameters, 
				(string)$method['returnType'], 
				(string)$method->body, 
				(string)$method['description']
			);			
		}
	}