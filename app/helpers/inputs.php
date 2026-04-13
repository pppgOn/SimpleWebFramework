<?php

enum Input {
	case BUTTON;
	case CHECKBOX;
	case COLOR;
	case DATE;
	case DATETIMELOCAL;
	case EMAIL;
	case FILE;
	case HIDDEN;
	case IMAGE;
	case MONTH;
	case NUMBER;
	case PASSWORD;
	case RADIO;
	case RANGE;
	case RESET;
	case SEARCH;
	case SUBMIT;
	case TEL;
	case TEXT;
	case TIME;
	case URL;
	case WEEK;
}

function get_input_type_display_name(Input $input) {

}
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