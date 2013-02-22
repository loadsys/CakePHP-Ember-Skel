<?php

class TemplateFile {
	public $tag = "<script type=\"text/x-handlebars\" data-template-name=\"%s\">\n%s\n</script>";
	public function __construct($basePath, $filePath) {
		$this->ds = DIRECTORY_SEPARATOR;
		$this->basePath = $basePath;
		$this->filePath = $filePath;
	}

	public function absolutePath() {
		return $this->joinPath($this->basePath, $this->filePath);
	}

	public function templateName() {
		$path = explode('.', $this->filePath);
		$path = $path[0];
		$path = explode($this->ds, $path);
		$bits = array();
		foreach ($path as $index => $part) {
			$bits[] = $this->convertName($part);
		}
		return implode('/', $bits);
	}

	public function convertName($name) {
		$partial = false;
		if ($name[0] === '_') {
			$name = ltrim($name, '_');
			$partial = true;
		}
		$name = str_replace(array('_', '-'), ' ', $name);
		$name = lcfirst(str_replace(' ', '', ucwords($name)));
		if ($partial) {
			$name = '_' . $name;
		}
		return $name;
	}

	public function joinPath($path1, $path2) {
		return rtrim($path1,$this->ds).$this->ds.ltrim($path2,$this->ds);
	}

	public function content() {
		return trim(file_get_contents($this->absolutePath()));
	}

	public function wrappedContent() {
		$name = $this->templateName();
		$content = $this->content();
		return sprintf($this->tag, $name, $content);
	}

	public function compiledContent() {
		$node = exec('which node');
		$path = dirname(__FILE__) . DS;
		$file = $this->absolutePath();
		$fl = $path . 'compile-template.js';
		$tc = $path . 'ember-template-compiler.js';
		$output = array();

		if ($node) {
			$content  = 'Ember.TEMPLATES["' . $this->templateName() . '"] = ';
			exec(implode(' ', array('node', $fl, $tc, $file)), $output);
			$content = $content . implode("\n", $output) . ';';
		} else {
			$content = $this->wrappedContent();
		}
		return $content;
	}

	public function lastModified() {
		return filemtime($this->absolutePath());
	}

	public function cacheName() {
		return strtolower(str_replace('/', '_', $this->templateName())) . '_' . $this->lastModified();
	}
}

