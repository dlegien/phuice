<?php
	namespace org\legien\phuice\pathing;

	class ConditionGroup {
		
		protected $children;
		
		public function __construct() {
			$this->children = array();
		}
		
		public function set($child) {
			if($child instanceof ConditionGroup || $child instanceof Condition) {
				$this->children[] = $child;
				return $this;				
			}
			throw new \Exception('ConditionGroup.set(): A ConditionGroup can only accept other ConditionGroups or Conditions as children.');		
		}
		
		public function getChildren() {
			return $this->children;
		}
		
		public function getJoinOperation() {
			return $this->joinOperation;
		}
		
		public function setJoinOperation($joinOperation) {
			$this->joinOperation = $joinOperation;
			return $this;	
		}
		
		public function __toString() {
			foreach($this->children as $child) {
				if($child instanceof Condition) {
					$statements[] = (string)$child;
				}
				elseif($child instanceof ConditionGroup) {
					$statements[] = '('. $child .')';					
				}
			}
			return '' . join(' ' . $this->getJoinOperation() . ' ', $statements) . '';			
		}
	}
