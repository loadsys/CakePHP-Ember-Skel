<?php

App::uses('GenerateTask', 'Ember.Console/Command/Task');

class ControllerTask extends GenerateTask {
	public $validTypes = array('Controller', 'Array', 'Object');
	public $classType = 'Controller';
	public $classDir = 'Controller';
	public $output = "App.%s = Ember.%s.extend({\n\n});";

	public function execute() {
		if (empty($this->args)) {
			$this->interactive();
		} else {
			$this->hasArgs();
		}
	}

	protected function interactive() {
		$this->out('Interactive Controller Generator');
		$this->hr();
		$name = $this->in('What is the name for the controller?');
		$this->hr();
		$valid = array();
		foreach ($this->validTypes as $v) {
			$valid[] = $v[0];
			$this->out('[' . $v[0] . ']' . substr($v, 1));
		}

		$type = strtoupper($this->in('What type of controller is it?', $valid));
		switch ($type) {
			case 'C':
				$type = 'Controller';
				break;
			case 'A':
				$type = 'Array';
				break;
			case 'O':
				$type = 'Object';
				break;
			default:
				$this->out(__d('cake_console', 'You have made an invalid selection. Please choose a type to generate by entering ' . implode(', ', $valid)));
				exit(0);
				break;
		}
		$this->generateFile($name, $type);
	}

	protected function hasArgs() {
		$type = 'Controller';
		$name = $this->args[0];
		if (isset($this->args[1])) {
			$type = ucfirst($this->args[1]);
		}
		if (!in_array(ucfirst($type), $this->validTypes)) {
			$this->out('The supplied controller type was not valid. Valid types are: ' . implode(', ', $this->validTypes));
		}
		$this->generateFile($name, $type);
	}
}
