<?php

App::uses('AppHelper', 'View/Helper');
App::uses('TemplateFile', 'Ember.Lib');

class InvalidSettingException extends Exception {}

class HandlebarsHelper extends AppHelper {
	public $basePath = null;
	public $ext = array('handlebars', 'hbs');
	public $regex = "/^(.)+\.(%s){1}$/";
	public $compile = true;
	public $cache = true;

	public function __construct($View, $settings = array()) {
		parent::__construct($View, $settings);

		foreach (array('ext', 'cache') as $opt) {
			if (isset($settings[$opt])) {
				$this->{$opt} = $settings[$opt];
			}
		}

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
					$c = $this->getContent($file);
					Cache::write($file->cacheName(), $c);
				}
			} else {
				$c = $this->getContent($file);
			}
			$content[] = $c;
		}
		$content = implode("\n", $content);
		if ($this->compile) {
			$content = '<script>' . $content . '</script>';
		}
		return $content;
	}

	protected function getContent($file) {
		if ($this->compile) {
			$content = $file->compiledContent();
		} else {
			$content = $file->wrappedContent();
		}
		return $content;
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
