<?php

	/**
	 * Phuice - EP Framework
	 * Copyright (C) 2013 Daniel Legien
	 *
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 *
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 */

	namespace org\legien\phuice\storages;
	
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\EntityRepository;
	
	use org\legien\phuice\pathing\Statement;	
	use org\legien\phuice\pathing\evaluators\StatementEvaluator;
	use org\legien\phuice\services\doctrine\DoctrineTransaction;
					
	/**
	 * An abstract storage that uses Doctrine for ORM.
	 * 
	 * @author Daniel Legien
	 * @package org.legien.phuice
	 * @subpackage storages
	 */
	abstract class AbstractDoctrineStorage implements IAbstractStorage
	{
		/**
		 * The Doctrine Entity Manager.
		 * 
		 * @var EntityManager
		 */
		private $_entityManager;
		
		/**
		 * The name of the entity.
		 * 
		 * @var string
		 */
		private $_entityName;
		
		/**
		 * The evaluator for phuice statements.
		 * 
		 * @var StatementEvaluator
		 */
		private $_statementEvaluator;
		
		/**
		 * Constructor.
		 * 
		 * @param EntityManager $entityManager The Doctrine Entity Manager.
		 * @param StatementEvaluator $statementEvaluator The Phuice Statement Evaluator.
		 * @param string $entityName The name of the storage's entity.
		 */
		public function __construct(EntityManager $entityManager, StatementEvaluator $statementEvaluator, $entityName)
		{
			$this->setEntityManager($entityManager);
			$this->setEntityName($entityName);
			$this->setStatementEvaluator($statementEvaluator);
		}
		
		/**
		 * Returns the Doctrine Entity Manager
		 * 
		 * @return EntityManager
		 */
		private function getEntityManager()
		{
			return $this->_entityManager;
		}
		
		/**
		 * Sets the Doctrine Entity Manager.
		 * 
		 * @param EntityManager $entityManager The Doctrine Entity Manager
		 */
		private function setEntityManager($entityManager)
		{
			$this->_entityManager = $entityManager;
		}
		
		/**
		 * Returns the repository for the storage's entity. 
		 * 
		 * @return EntityRepository
		 */
		protected function getRepository()
		{
			return $this->getEntityManager()->getRepository($this->getEntityName());
		}
		
		/**
		 * Returns the entity's name.
		 * 
		 * @return string
		 */
		protected function getEntityName()
		{
			return $this->_entityName;
		}
		
		/**
		 * Sets the name of the storage's entity.
		 * 
		 * @param string $entityName The name of the entity.
		 */
		private function setEntityName($entityName)
		{
			$this->_entityName = $entityName;
		}
		
		/**
		 * Returns the statement evaluator.
		 * 
		 * @return \org\legien\phuice\pathing\evaluators\StatementEvaluator
		 */
		private function getStatementEvaluator()
		{
			return $this->_statementEvaluator;
		}
		
		/**
		 * Sets the statement evaluator.
		 * 
		 * @param StatementEvaluator $statementEvaluator
		 */
		private function setStatementEvaluator(StatementEvaluator $statementEvaluator)
		{
			$this->_statementEvaluator = $statementEvaluator;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\IAbstractStorage::delete()
		 */
		public function delete($entity)
		{
			$this->getEntityManager()->remove($entity);
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\IAbstractStorage::create()
		 */
		public function create($entity, $nesting = TRUE)
		{
			$this->getEntityManager()->persist($entity);
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\IAbstractStorage::update()
		 */		
		public function update($entity)
		{
			$this->getEntityManager()->flush($entity);
			return TRUE;
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\IAbstractStorage::findCustom()
		 */
		public function findCustom(Statement $stmt)
		{
			$statement = $this->getStatementEvaluator()->evaluate($stmt);
			$query = $this->getEntityManager()->createQuery($statement);
			return $query->getResult();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\IAbstractStorage::findAll()
		 */
		public function findAll(array $filters = array(), array $orderby = array(), $limit = false)
		{
			return $this->getEntityManager()->getRepository($this->getEntityName())->findAll();
		}
		
		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\storages\IAbstractStorage::createTransaction()
		 */
		public function createTransaction()
		{
			return new DoctrineTransaction($this->getEntityManager()->getConnection());
		}
		
		/**
		 * Flushes all changes to the database.
		 */
		public function flush()
		{
			$this->getEntityManager()->flush();
		}
	}