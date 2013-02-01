<?php

App::uses('AppShell', 'Console/Command');

class GenerateTask extends AppShell {
	public $validTypes = array();
	public $jsDir = 'js';
	public $appDir = 'app';
	public $classType = '';
	public $classDir = '';
	public $output = '';

	public function startup() {
		Configure::write('debug', 2);
		Configure::write('Cache.disable', 1);
		parent::startup();
	}

	public function generateFile($name, $type = null, $extras = null) {
		$path = $this->generateFilePath($name);
		if (file_exists($path)) {
			$this->out('File already exists at ' . $path);
			exit(0);
		}
		$handle = fopen($path, 'x');
		fwrite($handle, $this->generateFileContent($name, $type, $extras));
		fclose($handle);
		$this->out($this->generateFileName($name) . ' created at ' . str_replace(APP, '', $path));
	}

	public function generateFileContent($name, $type = null, $extras = '') {
		$name = $this->generateFileName($name);
		$type = $this->generateClassType($type);
		if (method_exists($this, 'generateExtras')) {
			$extras = $this->generateExtras($extras);
		}
		return vsprintf($this->output, array($name, $type, $extras));
	}

	public function generateFileName($name) {
		return ucfirst(preg_replace('/' . $this->classType . '$/', '', $name)) . $this->classType;
	}

	public function generateClassType($type = null) {
		if (!$type || !in_array(strtolower($type), array_map('strtolower', $this->validTypes))) {
			return $this->classType;
		}
		$type = ucfirst($type);
		if ($type !== $this->classType) {
			$type = $type . $this->classType;
		}
		return $type;
	}

	public function generateFilePath($name) {
		$name = $this->generateFileName($name);
		$root = APP . WEBROOT_DIR;
		$parts = array($root, $this->jsDir, $this->appDir, $this->classDir, $name);
		return implode(DS, $parts) . '.js';
	}
}