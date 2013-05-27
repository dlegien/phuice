<?php

	namespace org\legien\phuice\generator;
	
	use org\legien\phuice\generator\types\IModelGenerator;
	use org\legien\phuice\generator\types\IGatewayGenerator;
	use org\legien\phuice\structures\StructureGatewayInterface;
	
	class SimpleGenerator
	{
		private $_basepath;
		private $_rootNamespace;
		private $_structureGateway;
		private $_modelGenerator;
		private $_gatewayGenerator;
		
		public function __construct($basepath, $rootNamespace, StructureGatewayInterface $structureGateway, IModelGenerator $modelGenerator, IGatewayGenerator $gatewayGenerator)
		{
			$this->SetBasepath($basepath);
			$this->SetRootNamespace($rootNamespace);
			$this->SetStructureGateway($structureGateway);
			$this->SetModelGenerator($modelGenerator);
			$this->SetGatewayGenerator($gatewayGenerator);
		}
		
		private function SetRootNamespace($rootNamespace)
		{
			$this->_rootNamespace = $rootNamespace;
		}
		
		private function GetRootNamespace()
		{
			return $this->_rootNamespace;
		}
		
		private function SetModelGenerator(IModelGenerator $generator)
		{
			$this->_modelGenerator = $generator;
		}
		
		private function GetModelGenerator()
		{
			return $this->_modelGenerator;
		}
		
		private function SetGatewayGenerator(IGatewayGenerator $generator)
		{
			$this->_gatewayGenerator = $generator;
		}		
		
		private function GetGatewayGenerator()
		{
			return $this->_gatewayGenerator;
		}
		
		private function SetBasepath($basepath)
		{
			$this->_basepath = $basepath;
		}
		
		private function GetBasepath()
		{
			return $this->_basepath;
		}
		
		private function SetStructureGateway(StructureGatewayInterface $structureGateway)
		{
			$this->_structureGateway = $structureGateway;
		}
		
		private function GetStructureGateway()
		{
			return $this->_structureGateway;
		}
		
		private function GenerateSource($classname)
		{
			foreach(array($this->GetModelGenerator(), $this->GetGatewayGenerator()) as $generator) 
			{
				$source = $generator->generate($classname);
				$this->WriteFile($this->GetBasepath() . '/' . $generator->getClass($classname)->getFullQualifiedName(), $source);		
			}
		}
		
		public function Generate()
		{	
			$sgw = $this->GetStructureGateway();
			
			foreach ($sgw->findTables() as $table)
			{
				$nameparts = explode('_', $table->getName());
				$name = implode('', array_map('ucfirst', $nameparts));
				
				
				$fullQualifiedName = explode('\\', $this->GetRootNamespace() . '\\' . $name);
				$classname = implode('\\', array_slice($fullQualifiedName, -1));
				$namespace = implode('\\', array_slice($fullQualifiedName, 0, -1));
				$fqnString = implode('/', $fullQualifiedName);
			
				$columns = $sgw->findTableColumns($table);
				$indexes = $sgw->findTableIndexes($table);
			
				$modelFields = array();
				foreach($columns as $column)
				{
					$modelFields[$column->getName()] = $column->getPhpType();
				}
			
				$this->GetModelGenerator()->setClass(
					$classname,
					$namespace . DIRECTORY_SEPARATOR . 'models',
					$modelFields
				);
			
				$this->GetGatewayGenerator()->setClass(
					$classname,
					$namespace . DIRECTORY_SEPARATOR . 'storages',
					$this->GetModelGenerator()->getClass($classname),
					$indexes
				);
			
				$this->GenerateSource($classname);
			}
		}
	
		private function CreatePath($path)
		{
			$packages = explode('/', $path);
			$index = count($packages)-1;
			unset($packages[$index]);
			$folder = getcwd() . DIRECTORY_SEPARATOR;
			foreach($packages as $package)
			{
				$folder .= $package;
				if(!file_exists($folder))
				{
					mkdir($folder);
				}
				$folder .= DIRECTORY_SEPARATOR;
			}
		}
		
		private function WriteFile($path, $source)
		{
			$path = str_replace('\\', '/', $path) . '.php';
			
			echo "Writing $path" . PHP_EOL;
			
			$this->CreatePath($path);
			
			file_put_contents($path, $source);
		}
		
	}