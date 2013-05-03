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

	namespace org\legien\phuice\mailing;

	use org\legien\phuice\contacts\Contact;

	/**
	 * An email message.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mailing
	 */
	class Message 
	{
		/**
		 * The source address.
		 * @var Contact
		 */
		private $_from;
		
		/**
		 * The destination address.
		 * @var Contact
		 */
		private $_to;
		
		/**
		 * The message.
		 * @var string
		 */
		private $_message;
		
		/**
		 * The message encoding.
		 * @var string
		 */
		private $_encoding;

		/**
		 * Creates a new instance.
		 * 
		 * @param Contact $from		The source contact.
		 * @param Contact $to		The destination contact.
		 * @param string $message	The message.
		 * @param string $encoding	The message encoding.
		 */
		public function __construct(Contact $from, Contact $to, $message, $encoding = 'utf-8') 
		{
			$this->setFrom($from);
			$this->setTo($to);
			$this->setMessage($message);
			$this->setEncoding($encoding);
		}

		/**
		 * Sets the source contact.
		 * 
		 * @param Contact $from	The source contact.
		 * 
		 * @return Message
		 */
		public function setFrom(Contact $from) 
		{
			$this->_from = $from;
			return $this;
		}

		/**
		 * Sets the destination contact.
		 * 
		 * @param Contact $to	The destination contact.
		 * 
		 * @return Message
		 */
		public function setTo(Contact $to) 
		{
			$this->_to = $to;
			return $this;
		}

		/**
		 * Sets the message.
		 * 
		 * @param string $message	The message.
		 * 
		 * @return Message
		 */
		public function setMessage($message) 
		{
			$this->_message = $message;
			return $this;
		}

		/**
		 * Sets the encoding.
		 * 
		 * @param string $encoding	The encoding.
		 * 
		 * @return Message
		 */
		public function setEncoding($encoding) 
		{
			$this->_encoding = $encoding;
			return $this;
		}

		/**
		 * Returns the source contact.
		 * 
		 * @return Contact
		 */
		public function getFrom() 
		{
			return $this->_from;
		}

		/**
		 * Returns the destination contact.
		 * 
		 * @return Contact
		 */
		public function getTo() 
		{
			return $this->_to;
		}

		/**
		 * Returns the message text.
		 * 
		 * @return string
		 */
		public function getMessage() 
		{
			return $this->_message;
		}

		/**
		 * Returns the encoding.
		 * 
		 * @return string
		 */
		public function getEncoding() 
		{
			return $this->_encoding;
		}
	}
