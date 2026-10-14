<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';

class BootstrapController extends Controller {
	/** @var array<string> $stylesheets */
	protected array $stylesheets = array('bootstrap/css/bootstrap.min.css');

	/** @var array<string> $scripts */
	protected array $scripts = array('bootstrap/js/bootstrap.min.js');
	protected string $accept;

	public function __construct() {
		parent::__construct();

		$this->accept = is_string($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
		if (str_contains($this->accept, 'text/html')) {
			$stylesheets_html = '';
			foreach ($this->stylesheets as $stylesheet) {
				$stylesheets_html .= '<link href="' . $stylesheet .'" rel="stylesheet"/>';
			}

			echo '<!doctype html>' .
					'<html lang="en">' .
					'<head>' .
						'<meta charset="utf-8"/>' .
						'<meta name="viewport" content="width=device-width, initial-scale=1"/>' .
						$stylesheets_html .
					'</head>' . 
				'<body>';
		}
	}

	function __destruct() {
		if (str_contains($this->accept, 'text/html')) {
			foreach($this->scripts as $script) {
				echo '<script src="' . $script .'"></script>';
			}
			echo '</body></html>';
		}
	}
}