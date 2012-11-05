<?php

	namespace org\legien\phuice\pathing\evaluators;

	use org\legien\phuice\pathing\Statement;

	interface StatementEvaluator {	

		public function evaluate(Statement $statement);			
	}
	

