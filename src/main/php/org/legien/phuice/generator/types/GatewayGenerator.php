<?php

	namespace org\legien\phuice\generator\types;
	
	use org\legien\phuice\generator\components\ClassDefinition;
	use org\legien\phuice\generator\components\Parameter;
	use org\legien\phuice\generator\components\Field;
	use org\legien\phuice\generator\components\Method;
	use org\legien\phuice\generator\components\Dependency;	
	use org\legien\phuice\generator\languages\LanguageGeneratorInterface;
	use org\legien\phuice\generator\types\ITypeGenerator;

	/**
	 * The GatewayGenerator defines all the fields and methods required by
	 * a standard gateway. It uses a language specific generator to
	 * generate the actual source code.
	 * 
	 * @author		Daniel Legien
	 * 				Rüdiger Willmann <r.willmann@design-it.de>
	 * @package		org.legien.phuice.generator
	 * @subpackage	types
	 *  
	 */	
	class GatewayGenerator implements IGatewayGenerator
	{
		/**
		 * The language specific generator that generates
		 * the source code.
		 *
		 * @var	LanguageGeneratorInterface
		 */
		private $generator;
		
		/**
		 * The addition to the gateway name.
		 * 
		 * @var string
		 */
		protected $gatewayNameAddition = 'TableDataGateway';
		
		/**
		 * The namespace of the base gateway.
		 * 
		 * @var string
		 */
		protected $baseGatewayNamespace = '\api\DataAbstraction\TableDataGateway';
		
		/**
		 * The namespace of the filter object.
		 * 
		 * @var string
		 */
		protected $filterNamespace = '\api\DataAbstraction\TableDataGatewayFilter';
		
		/**
		 * The namespace of the ordering object.
		 * 
		 * @var string
		 */
		protected $orderingNamespace = '\api\DataAbstraction\TableDataGatewayOrder';
		
		/**
		 * Creates a new GatewayGenerator that uses the given language specific 
		 * generator to create the source code.
		 * 
		 * @param	LanguageGeneratorInterface	$generator	The language specific generator.
		 * 
		 */
		public function __construct(LanguageGeneratorInterface $generator)
		{
			$this->generator = $generator;
		}
		
		/**
		 * Extracts the class name from a namespace.
		 * 
		 * @param string $namespace The namespace.
		 * 
		 * @return string
		 */
		protected function extractClassFromNamespace($namespace)
		{
			$namespaces = explode('\\', $namespace);
			$index = count($namespaces)-1;
			return $namespaces[$index];
		}
		
		/**
		 * Extracts the base gateway class from the namespace.
		 * 
		 * @return string
		 */
		protected function getBaseGatewayClass()
		{
			return $this->extractClassFromNamespace($this->baseGatewayNamespace);
		}
		
		/**
		 * Extracts the filter class from the filter namespace.
		 * 
		 * @return string
		 */
		protected function getFilterClass()
		{
			return $this->extractClassFromNamespace($this->filterNamespace);
		}
		
		/**
		 * Extracts the ordering class from the ordering namespace.
		 * 
		 * @return string
		 */
		protected function getOrderingClass()
		{
			return $this->extractClassFromNamespace($this->orderingNamespace);
		}
		
		/**
		 * Returns the name of the gateway by appending 'TableDataGateway' to
		 * the given name.
		 * 
		 * @param	string	$gatewayName	The name of the class.
		 * 
		 * @return	string
		 */
		protected function getGatewayName($gatewayName)
		{
			return $gatewayName.$this->gatewayNameAddition;
		}
				
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
		public function setClass($gatewayName, $namespace, $modelClass, $indexes = array())
		{
			$modelName = $modelClass->getFullQualifiedName();
			
			// Prepare the name of the class
			$gatewayName = $this->getGatewayName($gatewayName);
			
			// Define the class and its base attributes
			$class = new ClassDefinition($gatewayName, $namespace);
			
			// Set optional attributes of the class
			$class
				->setDescription("An automatically generated gateway class for $gatewayName.")
				->setAbstract(FALSE)
				->setAuthor('Generator')
				->setExtends($this->getBaseGatewayClass())
				->setDependency(new Dependency($this->baseGatewayNamespace))
				->setDependency(new Dependency($this->filterNamespace))
				->setDependency(new Dependency($this->orderingNamespace))
				// ->setImplements('\api\DataAbstraction\DataGatewayInterface')
			;
			
			// Set the fields
			$class->setField(new Field(
				'connection',
				'PDOService',
				'The database connection.',
				'protected'
			));
			
			$class->setField(new Field(
				'table',
				'string',
				'The table that holds the information.',
				'protected'
			));
			
			$class->setField(new Field(
				'modelName',
				'string',
				'The name of the gateway\'s model.',
				'protected',
				$modelName
			));			

			// Compose the required methods
			$class->setMethod($this->composeConstructorMethod());						
			
			foreach($indexes as $index)
			{
				$parameters = array();
				foreach($index->getIndexColumns() as $indexColumn)
				{
					$parameters[] = new Parameter(
						$indexColumn->getName(),
						$indexColumn->getPhpType()
					);
				}
				
				$composeMethod = $index->getUnique() ? 'composeFindByMethod' : 'composeFindAllByMethod';
				
				$class->setMethod(
					$this->$composeMethod(
						//$gatewayName,
						$index->getName(),
						$parameters,
						$modelClass->getFullQualifiedName()
					)
				);
			}
			 
			// Save the class definition
			$this->classes[$gatewayName] = $class;
			
			return $this;		
		}
		
		/**
		 * Composes the constructor method for the standard gateway.
		 * 
		 * @return	Method
		 */
		private function composeConstructorMethod()
		{
			// Compose the constructor method
			return new Method('__construct', 
				array(
					new Parameter('connection', ''),
					new Parameter('table', 'string')
				),
				NULL, 
				'$this->connection = $connection;' . PHP_EOL . '$this->table = $table;', 
				'Constructor for the Gateway class'
			);	
		}
		
		/**
		 * Returns an array of gateway filters for the specified parameters.
		 * 
		 * @param	array 	$parameters	The parameters for a method.
		 * 
		 * @return	array
		 */
		private function getGatewayFiltersByParameters($parameters)
		{			
			$gatewayFilter = array();
			foreach ($parameters as $filter)
			{
				$gatewayFilter[] =
					"\t"
					. 'new ' . $this->getFilterClass() . '(\''
					. $filter->getName()
					. '\', \'=\', ('
					. $filter->getType()
					. ')$'
					. $filter->getName()
					. ')'
				;
			}
			return $gatewayFilter;
		}
		
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
		public function composeFindByMethod($name, $parameters, $returnType)
		{
			return new Method(
				'findBy' . ucfirst($name), 
				$parameters,
				$returnType, 
				'return parent::find(array('
				. PHP_EOL
				. implode(
					',' . PHP_EOL,
					$this->getGatewayFiltersByParameters($parameters)
				) . PHP_EOL
				. '));', 
				'Auto-generated method to find "' . $returnType . '" by index "' . $name . '".'
			);		
		}
		
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
		public function composeFindAllByMethod($name, $parameters, $returnType)
		{
			return new Method(
				'findAllBy' . ucfirst($name), 
				$parameters,
				$returnType, 
				'return parent::findAll(array('
				. PHP_EOL
				. implode(
					',' . PHP_EOL,
					$this->getGatewayFiltersByParameters($parameters)
				) . PHP_EOL
				. '));', 
				'Auto-generated method to find "' . $returnType . '" by index "' . $name . '".'
			);			
		}		
		
		/**
		 * Returns whether a definition for the given name exists.
		 * 
		 * @param	string	$name	The name of the class.
		 * 
		 * @return	bool
		 */
		public function hasClassDefinition($name)
		{
			return key_exists($this->getGatewayName($name), $this->classes);
		}		
		
		/**
		 * Returns the class definition for the given name or throws an
		 * InvalidArgumentException if no definition with the name exists.
		 * 
		 * @param	string	$name	The name of the class.
		 * 
		 * @return	ClassDefinition
		 * @throws	InvalidArgumentException If no class definition exists for the given name.
		 */		
		public function getClass($name)
		{
			if($this->hasClassDefinition($name))
			{
				return $this->classes[$this->getGatewayName($name)];
			}
			throw new \InvalidArgumentException('No class definition with this name exists.');
		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\generator\types\ITypeGenerator::generate()
		 */
		public function generate($name)
		{
			return $this->generator->generate($this->classes[$this->getGatewayName($name)]);
		}
	}