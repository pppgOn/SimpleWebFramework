<?php

enum Method
{
	case GET;
	case POST;
	case PUT;
	case DELETE;
	case UPDATE;
}

function get_server_http_method() : ?Method {
	$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
	if (!$method) {
		return null;
	}
	switch (strtolower($method)) {
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
