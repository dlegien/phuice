<?php

	namespace org\legien\phuice\storages;
	
	interface IDoctrineEntityManagerWrapper
	{
		public function flush();
		
		public function getRepository($entityName);
		
		public function persist($entity);
		
		public function update($entity);
		
		public function getConnection();
		
		public function createTransaction();
		
		public function createQuery($statement);
		
		public function remove($entity);
	}