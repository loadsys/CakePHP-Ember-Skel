<?php

App::uses('GenerateTask', 'Ember.Console/Command/Task');

class RouteTask extends GenerateTask {
	public $classDir = 'Route';
	public $classType = 'Route';
	public $output = "App.%s = Ember.Route.extend({\n\n});";

	public function execute() {
		if (empty($this->args)) {
			$this->interactive();
		} else {
			$this->hasArgs();
		}
	}

	protected function interactive() {
		$this->out('Interactive Route Generator');
		$this->hr();
		$this->generateFile($this->in('What is the name for the route?'));
	}

	protected function hasArgs() {
		$this->generateFile($this->args[0]);
	}
}
