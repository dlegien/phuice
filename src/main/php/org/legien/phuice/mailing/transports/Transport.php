<?php

	namespace org\legien\phuice\mailing\transports;

	use org\legien\phuice\mailing\Message;

	interface Transport {
		
		public function send(Message $message);

	}
