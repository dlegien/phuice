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

	use org\legien\phuice\mailing\transports\Transport;

	/**
	 * A mailer that delivers messages using a given
	 * transport protocol.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice
	 * @subpackage	mailing
	 */
	class Mailer 
	{
		/**
		 * The transport.
		 * @var Transport
		 */
		private $_transport;		

		/**
		 * Creates a new instance.
		 * 
		 * @param Transport $transport The transport.
		 */
		public function __construct(Transport $transport) 
		{
			$this->setTransport($transport);
		}

		/**
		 * Sets the transport.
		 * 
		 * @param Transport $transport	The transport.
		 * 
		 * @return Mailer
		 */
		public function setTransport(Transport $transport) 
		{
			$this->_transport = $transport;
			return $this;
		}

		/**
		 * Returns the transport.
		 * 
		 * @return Transport
		 */
		public function getTransport() 
		{
			return $this->_transport;
		}

		/**
		 * Sends the message.
		 * 
		 * @param Message $message	The message.
		 */
		public function send(Message $message) 
		{
			$this->getTransport()->send($message);
		}

	}
