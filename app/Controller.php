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

#[Attribute]
class Form {
	/** @var array<string,array{type:string,?default:mixed}> $fields */
	private array $fields;
	private Method $method;

	/**
	 * @param array<string,array{type:string,?default:mixed}> $fields
	 */
	public function __construct(array $fields) {
		$this->fields = $fields;
	}

	public function render() : string {
		$form = '<form action="' . htmlentities(get_http_method_display_name($this->method)) . '">';
		foreach ($this->fields as $name => $field) {
			switch ($field['type']) {
				case 'button':
					break;

				case 'checkbox':
					break;

				case 'color':
					break;

				case 'date':
					break;

				case 'datetime-local':
					break;

				case 'email':
					break;

				case 'file':
					break;

				case 'hidden':
					break;

				case 'image':
					break;

				case 'month':
					break;

				case 'number':
					break;

				case 'password':
					break;

				case 'radio':
					break;

				case 'range':
					break;

				case 'reset':
					break;

				case 'search':
					break;

				case 'submit':
					break;

				case 'tel':
					break;

				case 'text':
					$form .= '<input type="text" class="form-control" name="' . htmlentities($name) . '" id="exampleInputEmail1">';
					break;

				case 'time':
					break;

				case 'url':
					break;

				case 'week':
					break;

				default:
					throw new InternalErrorException('provided field type is not handle yet');
			}
		}

		return $form . '<form/>';
	}

	public function get_field_value(string $name) : mixed {
		if (!array_key_exists($name, $this->fields)) {
			throw new InternalErrorException('Unknown filed name requested in a form');
		}

		$filter = FILTER_UNSAFE_RAW;
		switch ($this->fields[$name]['type']) {
			case ''
				break;
		}

		$value = filter_input(INPUT_POST, $name, $filter);
	}
}