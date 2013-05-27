<?php

	namespace org\legien\phuice\generator\types\phuice;
	
	use org\legien\phuice\generator\types\GatewayGenerator;
	use org\legien\phuice\generator\languages\LanguageGeneratorInterface;
	
	class DBStorageGenerator extends GatewayGenerator
	{
		public function __construct(LanguageGeneratorInterface $generator)
		{
			parent::__construct($generator);
			$this->baseGatewayNamespace = 'org\\legien\\phuice\\storages\\AbstractDBStorage';
			$this->filterNamespace = 'org\\legien\\phuice\\storages\\StorageFilter';
			$this->orderingNamespace = 'org\\legien\\phuice\\storages\\StorageOrdering';
			$this->gatewayNameAddition = 'DBStorage';
		}
	}