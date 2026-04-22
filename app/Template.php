<?php

define('TEMPLATE_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'templates');

class Template {
	/** @var array<string,string> $variables */
	private array $variables = array();
	private string $file_path;

	/**
	 * @param string $file_name the name of the template file, without the extension
	 */
	public function __construct(string $file_name) {
		// Resolve template path symbolic link if it is
		$template_path = TEMPLATE_PATH;
		if (is_link($template_path)) {
			$template_path = readlink($template_path);
			if (!$template_path) {
				throw new InternalErrorException('Template path is a symbolic link wich is invalid');
			}
		}

		// Ensure file existence
		$this->file_path = $template_path . DIRECTORY_SEPARATOR . $file_name . '.tpl';
		if (!file_exists($this->file_path)) {
			throw new InternalErrorException('Usage of a non existing template');
		}
	}

	public function __toString() : string {
		$template_content = file_get_contents($this->file_path);
		if (!$template_content) {
			throw new InternalErrorException('Unable to read a template');
		}

		// Add the surronding brackets around variables name
		$variables = array();
		foreach (array_keys($this->variables) as $variable) {
			array_push($variables, '{{' . $variable . '}}');
		}

		// Replace variables and return the template
		return str_replace($variables, array_values($this->variables), $template_content);
	}

	public function setHTML(string $variable_name, string $value) : void {
		$this->variables[$variable_name] = $value;
	}

	/**
	 * This function automaticly escape the value passed
	 * If you want HTML to be had in the value (make sure it's escaped before), use the setHTML method
	 */
	public function set(string $variable_name, string $value) : void {
		$this->setHTML($variable_name, htmlentities($value));
	}
	
	public function appendHTML(string $variable_name, string $value) :void {
		if (!array_key_exists($variable_name, $this->variables)) {
			$this->setHTML($variable_name, $value);
		} else {
			$this->variables[$variable_name] .= $value;
		}
	}

	/**
	 * This function automaticly escape the value passed
	 * If you want HTML to be had in the value (make sure it's escaped before), use the appendHTML method
	 */
	public function append(string $variable_name, string $value) : void {
		if (!array_key_exists($variable_name, $this->variables)) {
			$this->set($variable_name, $value);
		} else {
			$this->variables[$variable_name] .= htmlentities($value);
		}
	}
}
