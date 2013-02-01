<?php

App::uses('AppHelper', 'View/Helper');
App::uses('TemplateFile', 'Ember.Lib');

class InvalidSettingException extends Exception {}

class HandlebarsHelper extends AppHelper {
	public $basePath = null;
	public $ext = array('handlebars', 'hbs');
	public $regex = "/^(.)+\.(%s){1}$/";
	public $cache = true;

	public function __construct($View, $settings = array()) {
		parent::__construct($View, $settings);

		if (isset($settings['basePath'])) {
			$this->basePath = $settings['basePath'];
		} else {
			$this->basePath = APP . WEBROOT_DIR;
		}
	}

	public function templates($path = null) {
		$content = array();
		foreach ($this->_buildPaths($path) as $template) {
			$basePath = $this->basePath . DS . $path;
			$filePath = ltrim(str_replace($basePath, '', $template), DS);
			$file = new TemplateFile($basePath, $filePath);
			$c = '';
			if ($this->cache) {
				if (!$c = Cache::read($file->cacheName())) {
					$c = $file->wrappedContent();
					Cache::write($file->cacheName(), $c);
				}
			} else {
				$c = $file->wrappedContent();
			}
			$content[] = $c;
		}
		return implode("\n", $content);
	}

	protected function _buildPaths($path) {
		$path = $this->basePath . DS . $path;
		$paths = array();
		$dir = new RecursiveDirectoryIterator($path);
		$iterator = new RecursiveIteratorIterator($dir);
		$regex = $this->_buildRegex();
		foreach ($iterator as $key => $val) {
			if (preg_match($regex, $key)) {
				$paths[] = $key;
			}
		}
		return $paths;
	}

	protected function _buildRegex() {
		$regex = '';
		if (is_array($this->ext)) {
			$regex = $regex . implode($this->ext, '|');
		} elseif (is_string($this->ext)) {
			$regex = $regex . $this->ext;
		} else {
			throw new InvalidSettingException('The ext setting must be a string or array of strings');
		}
		return sprintf($this->regex, $regex);
	}
}
