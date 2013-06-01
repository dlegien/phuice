<?php

	use org\legien\phuice\testing\TestBase;
	use org\legien\phuice\generator\SimpleGenerator;
	use org\legien\phuice\generator\types\ModelGenerator;
	use org\legien\phuice\generator\types\GatewayGenerator;
	use org\legien\phuice\structures\StructureGateway;
	use org\legien\phuice\io\MockWriter;
	use org\legien\phuice\generator\types\MockGatewayGenerator;
	use org\legien\phuice\generator\types\MockModelGenerator;
	use org\legien\phuice\structures\MockStructureGateway;
use org\legien\phuice\structures\Table;

	class SimpleGeneratorTest extends TestBase
	{
		public function setUp()
		{
			$this->modelGenerator = new MockModelGenerator();			
			$this->gatewayGenerator = new MockGatewayGenerator();
			$this->mockWriter = new MockWriter();
			$this->mockStructureGateway = new MockStructureGateway(
				array(new Table()),
				array(),
				array()
			);
		}
		
		public function testGeneration()
		{
			/*
			$generator = new SimpleGenerator(
					'path',
					'namespace',
					$this->mockStructureGateway,
					$this->modelGenerator,
					$this->gatewayGenerator,
					$this->mockWriter
			);

			
			
			$generator->Generate();
			*/
		}
	}