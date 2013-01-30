<?php

App::uses('GenerateTask', 'Ember.Console/Command/Task');

class ModelTask extends GenerateTask {
	public $classDir = 'Model';
	public $output = "App.%s = DS.%s.extend({\n\n});";

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
}
