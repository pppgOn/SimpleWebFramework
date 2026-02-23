<?php

class HTTPException extends Exception {}

class InternalErrorException extends HTTPException {
	public function __construct(string $message) {
		parent::__construct($message, 500);
	}
}

class NotFoundException extends HTTPException {
	public function __construct(string $message) {
		parent::__construct($message, 500);
	}
}

class BadRequestException extends HTTPException {
	public function __construct(string $message) {
		parent::__construct($message, 500);
	}
}