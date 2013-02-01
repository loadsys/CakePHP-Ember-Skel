<?php

App::uses('GenerateTask', 'Ember.Console/Command/Task');

class ModelTask extends GenerateTask {
	public $validTypes = array('Model');
	public $classDir = 'Model';
	public $output = "App.%s = DS.%s.extend({\n%s\n});";

	public function execute() {
		if (empty($this->args)) {
			$this->interactive();
		} else {
			$this->hasArgs();
		}
	}

	protected function interactive() {
		$this->out('Interactive Model Generator');
		$this->hr();
		$this->generateFile($this->in('What is the name for the model?'), 'Model');
	}

	protected function hasArgs() {
		$this->generateFile($this->args[0], 'Model');
	}

	protected function generateExtras($extras) {
		if (!is_array($extras)) {
			return '';
		}
		$valid = array('string', 'number', 'bool', 'boolean', 'date');
		return implode(",\n", array_map(function($i) use ($valid) {
			$bits = explode(':', $i.':string');
			if (!in_array($bits[1], $valid)) {
				$bits[1] = 'string';
			}
			if ($bits[1] === 'bool') {
				$bits[1] = 'boolean';
			}
			return vsprintf("\t%s: DS.attr('%s')", $bits);
		}, $extras));
	}
}
