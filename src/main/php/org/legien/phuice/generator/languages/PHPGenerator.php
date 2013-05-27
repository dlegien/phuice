<?php

	namespace org\legien\phuice\generator\languages;
	
	use org\legien\phuice\generator\AbstractGenerator;
	use org\legien\phuice\generator\components\ClassDefinition;
	use org\legien\phuice\generator\components\Field;
	use org\legien\phuice\generator\components\Method;
	use org\legien\phuice\generator\components\Parameter;	
	use org\legien\phuice\generator\languages\LanguageGeneratorInterface;	
	use org\legien\phuice\generator\documentation\PHPDocumentationGenerator;	

	/**
	 * The PHPGenerator converts a class definition into PHP
	 * source code.
	 * 
	 * @author		Daniel Legien
	 * @package		org.legien.phuice.generator
	 * @subpackage	languages
	 * 
	 */
	class PHPGenerator extends AbstractGenerator implements LanguageGeneratorInterface
	{
		/**
		 * The generator class for the documentation.
		 *
		 * @var	DocumentationGeneratorInterface
		 */		
		private $docGenerator;

		/**
		 * Constructor.
		 */
		public function __construct()
		{
			$this->docGenerator = new PHPDocumentationGenerator;
		}	
		
		/**
		 * Generates source code of a method block including a description block.
		 * 
		 * @param string	$name			The name of the method.
		 * @param array		$parameters		The parameters of the method.
		 * @param string	$description	The description of the method.
		 * @param string	$visibility		The visibility of the method.
		 * @param string	$body			The source of the method's body.
		 * @param string	$returnType		The returntype of the method.
		 * 
		 * @return string
		 */
		private function generateMethod($name, $parameters = array(), $description = NULL, $visibility = 'public', $body = '', $returnType = NULL)
		{			
			$params = array();
			$description = (is_null($description) ? '' : $description . PHP_EOL);
			foreach($parameters as $parameter) 
			{
				$description .= $this->docGenerator->generateDocBlockAnnouncement(
					'param',
					$parameter->getType(),
					'$' . $parameter->getName(),
					$parameter->getDescription()
				);
				$params[] = '$' . $parameter->getName() . ($parameter->getDefaultValue() != '' ? ' = ' . $parameter->getDefaultValue() : '');				
			}
			$description .= $this->docGenerator->generateDocBlockAnnouncement(
				'return',
				$returnType
			);
			
			$docBlock = $this->docGenerator->generateDocBlock($description);
			
			$function = $this->concat(
				$visibility, ($visibility) ? ' ' : '',
				'function ', $name, '(', implode(', ', $params), ') '
			);
			
			$body = $this->indentTextBlock($this->parseBody($body));
			
			return $this->concat_ws(
				PHP_EOL,
				$docBlock,
				$function, '{' , $body , '}'
			);			
		}
		
		/**
		 * Parses the source code of the method's body and replaces the
		 * %%variable%%, and %%field%% placeholders with $ and $this->.
		 * 
		 * @param	string $body The source code for the body.
		 * @return	string
		 */
		private function parseBody($body)
		{
			return str_replace(
				array('%%variable%%', '%%field%%'),
				array("\$", "\$this->"),
				$body
			);
		}
		
		/**
		 * Generates source code of a property definition block.
		 * 
		 * @param string $name			The name of the property.
		 * @param string $type			The type of the property.
		 * @param string $description	The description of the property.
		 * 
		 * @return string
		 */
		private function generateField($name, $type, $description, $defaultValue)
		{
			return $this->concat_ws(PHP_EOL,
				$this->docGenerator->generateDocBlock(
					$this->concat_ws(PHP_EOL,
						(!is_null($description) ? $description : ''),
						$this->docGenerator->generateDocBlockAnnouncement('var', $type)
					)
				),
				'$' . $name . (!is_null($defaultValue) ? $defaultValue : '')				
			);			
		}
		
		/**
		 * Generates the source code for a setter method with the
		 * given name and type.
		 * 
		 * @param	string	$name	The name of the variable to set.
		 * @param	string	$type	The type of the variable.
		 * 
		 * @return	string
		 */
		private function generateSetter($name, $type)
		{
			return $this->generateMethod(
				'set' . ucwords($name), 
				array(
					new Parameter($name, $type)
				),
				"Sets $name to the given value.",
				'public',
				"%%field%%$name = ($type)%%variable%%$name;"
			);	
		}
		
		/**
		 * Generates the source code for a getter method with the
		 * given name and type.
		 * 
		 * @param	string	$name	The name of the variable to set.
		 * @param	string	$type	The type of the variable.
		 * 
		 * @return	string
		 */		
		private function generateGetter($name, $type)
		{
			return $this->generateMethod(
				'get' . ucwords($name),
				array(),
				"Returns the value of $name.",
				'public',
				"return ($type)%%field%%$name;",
				$type				
			);
		}		
		
		/**
		 * Generates the header information of the class source code.
		 * 
		 * @param string			$mainpackage	The mainpackage.
		 * @param string			$subpackage		The subpackage.
		 * @param ClassDefinition	$class			The class definition.
		 * 
		 * @return string
		 */
		private function generateHead($mainpackage, $subpackage, $class)
		{
			$namespace = (strlen($class->getNamespace()))
				? 'namespace ' . $class->getNamespace() . ';' . PHP_EOL . PHP_EOL
				: '';
			
			$description = $this->docGenerator->generateDocBlock(
				$this->concat(
					$class->getDescription() . PHP_EOL,
					$this->docGenerator->generateDocBlockAnnouncement('author',		$class->getAuthor()),
					$this->docGenerator->generateDocBlockAnnouncement('package',		$mainpackage),
					$this->docGenerator->generateDocBlockAnnouncement('subpackage',	$subpackage)
				)
			);
			
			$dependencies = array();
			foreach($class->getDependencies() as $dependency)
			{
				$dependencies[] = 'use ' . $dependency->getName() . ($dependency->hasAlias() ? ' as ' . $dependency->getAlias() : '') . ';'; 
			}
			
			return 
				$this->concat(
					$namespace,
					implode(PHP_EOL, $dependencies) . PHP_EOL . PHP_EOL,
					$description . PHP_EOL,
					($class->getAbstract() ? 'abstract ' : '') . 'class '.$class->getName(),
					(count($class->getExtends()) ? ' extends ' . implode(', ', $class->getExtends()) : ''),
					(count($class->getImplements()) ? ' implements ' . implode(', ', $class->getImplements()) : '')
				);
		}
		
		/**
		 * Returns the packages by splitting the namespace.
		 * 
		 * @param string $namespace The namespace.
		 * 
		 * @return array
		 */
		private function getPackages($namespace)
		{
			return explode('\\', $namespace);
		}

		/**
		 * Returns the subpackage from the namespace.
		 * 
		 * @param string $namespace The namespace.
		 * 
		 * @return string
		 */
		private function getSubPackages($namespace)
		{
			if(!empty($namespace))
			{
				$packages = $this->getPackages($namespace);
				$index = count($packages)-1;
				
				if(isset($packages[$index]))
				{
					return $packages[$index];
				}
			}
			
			return '';			
		}
				
		/**
		 * Returns the mainpackage from the namespace.
		 * 
		 * @param string $namespace The namespace.
		 * 
		 * @return string
		 */
		private function getMainPackage($namespace)
		{
			if(!empty($namespace))
			{
				$packages = $this->getPackages($namespace);
				$index = count($packages)-1;
				
				if(isset($packages[$index]))
				{
					unset($packages[$index]);
					return implode('.', $packages);
				}
			}
			
			return '';			
		}

		/**
		 * Generates the source code by evaluating the given class
		 * definition.
		 * 
		 * @param ClassDefinition $class	The class.
		 * 
		 * @throws \RuntimeException If a problem occurs during generation.
		 * 
		 * @return string
		 */
		public function generate(ClassDefinition $class)
		{
			$head = $this->generateHead(
				$this->getMainPackage($class->getNamespace()), 
				$this->getSubPackages($class->getNamespace()),
				$class
			);

			// Reset getters and setters
			$setters = array();
			$getters = array();
			$classFields = array();
			$methods = array();
		
			// Loop over all available fields 
			foreach($class->getFields() as $visibility => $fieldArray)
			{
				// Output the visibility
				$fields = array();
				if(count($fieldArray) > 0)
				{				
					foreach($fieldArray as $field)
					{
						$fields[] =	$this->generateField(
							$field->getName(),
							$field->getType(),
							$field->getDescription(),
							$field->getDefaultValue()
						);
						
						if($class->hasSetter($field->getName()))
						{
							$setters[] = $this->generateSetter($field->getName(), $field->getType());
						}
				
						if($class->hasGetter($field->getName()))
						{
							$getters[] = $this->generateGetter($field->getName(), $field->getType());
						}
										
					}
					
					$classFields[] = $this->concat_ws(
						PHP_EOL,
						$visibility,
						$this->indentTextBlock(
							implode(',' . PHP_EOL . PHP_EOL, $fields)
						),
						';'					
					);
					
				}

			}
			
			foreach($class->getMethods() as $method)
			{
				if($method instanceof Method)
				{
					$methods[] = $this->generateMethod(
						$method->getName(),
						$method->getParameters(),
						$method->getDescription(),
						$method->getVisibility(),
						$method->getBody(),
						$method->getReturnType()
					);
				}
				else
				{
					throw new \RuntimeException('Illegal method received. '. $method);
				} 
			}
			
			$body = $this->concat_ws(
				str_repeat(PHP_EOL, 2),
				implode(str_repeat(PHP_EOL, 2), $classFields),
				implode(str_repeat(PHP_EOL, 2), $methods),		
				implode(str_repeat(PHP_EOL, 2), $setters),
				implode(str_repeat(PHP_EOL, 2), $getters)
			);
			
			return $this->concat_ws(
				PHP_EOL,
				'<?php',
				'',
				$this->indentTextBlock(
					$this->concat_ws(
						PHP_EOL,
						$head, '{', $this->indentTextBlock($body), '}'
					)
				)
			);				
		}
	}