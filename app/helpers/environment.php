<?php

namespace Environment {
	$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
	$dotenv->load();

	function get(string $variable_name) : string {
		if (!array_key_exists($variable_name, $_ENV)) {
			throw new \InternalErrorException('Usage of an undefined environment variable');
		}

		$value = $_ENV[$variable_name];
		if (!is_bool($value) && !is_float($value) && !is_int($value) && !is_string($value)) {
			throw new \InternalErrorException('Usage of an environment variable with non supported type');
		}

		return strval($value);
	}
}