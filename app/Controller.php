<?php

class Controller {
	public function __construct() {
		
	}
}

#[Attribute]
class Route {
	private Method $method;
	private string $uri_regex;

	public function __construct(Method $method, string $uri_regex) {
		$this->method = $method;
		$this->uri_regex = $uri_regex;
	}

	/**
	 * @return false|array<string,string|int|bool> 
	 */
	public function match(Method $method, string $uri) : false | array {
		if ($method !== $this->method) {
			return false;
		}

		if (preg_match('@^/' . $this->uri_regex .'/?$@i', $uri, $matches)) {
			return array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY); // only keep named matches
		}

		return false;
	}
}