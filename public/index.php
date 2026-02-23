<?php

function include_directory_recursive(string $path) : void {
	$files = array_diff(scandir($path), array('.', '..'));
	foreach ($files as $file) {
		$filepath = $path . DIRECTORY_SEPARATOR . $file;
		if (is_dir($filepath)) {
			include_directory_recursive($filepath);
		} else if (preg_match('%\.php$%', $file)) {
			require_once($filepath);
		}
	}
}

enum Method
{
	case GET;
	case POST;
	case PUT;
	case DELETE;
	case UPDATE;
}

function get_server_http_method() : ?Method {
	switch (strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD'))) {
		case 'get':
			return Method::GET;
		case 'post':
			return Method::POST;
		case 'put':
			return Method::PUT;
		case 'delete':
			return Method::DELETE;
		case 'update':
			return Method::UPDATE;
		default:
			return null;
	}
}

$uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
if (!$uri) {
	header('Location: /');
	die();
}

$http_method = get_server_http_method();
if (!$http_method) {
	header('Location: /');
	die();
}

include_directory_recursive(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app');
foreach (get_declared_classes() as $controller) {
	if (!is_subclass_of($controller, Controller::class)) {
		continue;
	}

	$reflectionClass = new ReflectionClass($controller);
	$methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
	foreach ($methods as $method) {
		$reflectionMethod = new ReflectionMethod($controller, $method->getName());
		
		$attributes = $reflectionMethod->getAttributes(Route::class);
		foreach ($attributes as $attribute) {
			$args_matched = $attribute->newInstance()->match($http_method, $uri);
			if ($args_matched !== false) {
				$controller = new $controller();
				try {
					$controller->{$method->getName()}(...$args_matched);
				} catch (Exception $e) {
					if (is_subclass_of($e, HTTPException::class)) {
						http_response_code($e->getCode());
						// TODO: show message
					} else {
						http_response_code(500);
						// TODO: show message
					}
				}
			}
		}
	}
}

?>