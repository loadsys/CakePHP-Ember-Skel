<?php

App::uses('GenerateTask', 'Ember.Console/Command/Task');

class ViewTask extends GenerateTask {
	public $validTypes = array('View', 'Container', 'Collection');
	public $classType = 'View';
	public $classDir = 'View';
	public $output = "App.%s = Ember.%s.extend({\n\n});";

	public function execute() {
		if (empty($this->args)) {
			$this->interactive();
		} else {
			$this->hasArgs();
		}
	}

	protected function interactive() {
		$this->out('Interactive View Generator');
		$this->hr();
		$name = $this->in('What is the name for the view?');
		$this->hr();
		$valid = array();
		foreach ($this->validTypes as $i => $v) {
			$valid[] = $i + 1;
			$this->out('[' . ($i + 1) . ']' . $v);
		}

		$type = $this->in('What type of view is it?', $valid);
		switch ($type) {
			case '1':
				$type = 'View';
				break;
			case '2':
				$type = 'Container';
				break;
			case '3':
				$type = 'Collection';
				break;
			default:
				var_dump($type);
				$this->out(__d('cake_console', 'You have made an invalid selection. Please choose a type to generate by entering ' . implode(', ', $valid)));
				exit(0);
				break;
		}
		$this->generateFile($name, $type);
	}

	protected function hasArgs() {
		$type = 'View';
		$name = $this->args[0];
		if (isset($this->args[1])) {
			$type = ucfirst($this->args[1]);
		}
		if (!in_array(ucfirst($type), $this->validTypes)) {
			$this->out('The supplied view type was not valid. Valid types are: ' . implode(', ', $this->validTypes));
		}
		$this->generateFile($name, $type);
	}
}
