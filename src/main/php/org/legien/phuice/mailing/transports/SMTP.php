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

	namespace org\legien\phuice\mailing\transports;

	use org\legien\phuice\mailing\transports\Transport;
	use org\legien\phuice\mailing\Message;

	/**
	 * Implementation of the SMTP protocol.
	 * 
	 * @author 		Daniel Legien
	 * @package		org.legien.phuice.mailing
	 * @subpackage	transports
	 *
	 */
	class SMTP implements Transport 
	{
		/**
		 * Creates a new instance.
		 */
		public function __construct() 
		{

		}

		/**
		 * (non-PHPdoc)
		 * @see \org\legien\phuice\mailing\transports\Transport::send()
		 */
		public function send(Message $message) 
		{
		
		}
	}
