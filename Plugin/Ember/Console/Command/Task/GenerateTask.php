<?php

App::uses('AppShell', 'Console/Command/Task');

class GenerateTask extends AppShell {
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

	protected function generateFile($name, $type = null) {
		$path = $this->generateFilePath($name);
		if (file_exists($path)) {
			$this->out('File already exists at ' . $path);
			exit(0);
		}
		$handle = fopen($path, 'x');
		fwrite($handle, $this->generateFileContent($name, $type));
		fclose($handle);
		$this->out($this->generateFileName($name) . ' created at ' . str_replace(APP, '', $path));
	}

	protected function generateFileContent($name, $type = null) {
		$name = $this->generateFileName($name);
		$type = $this->generateClassType($type);
		return sprintf($this->output, $name, $type);
	}

	protected function generateFileName($name) {
		return ucfirst(preg_replace('/' . $this->classType . '$/', '', $name)) . $this->classType;
	}

	protected function generateClassType($type) {
		$type = ucfirst($type);
		if ($type !== $this->classType) {
			$type = $type . $this->classType;
		}
		return $type;
	}

	protected function generateFilePath($name) {
		$name = $this->generateFileName($name);
		$root = APP . WEBROOT_DIR;
		$parts = array($root, $this->jsDir, $this->appDir, $this->classDir, $name);
		return implode(DS, $parts) . '.js';
	}
}