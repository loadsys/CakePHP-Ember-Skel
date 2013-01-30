<?php

App::uses('AppShell', 'Console/Command');

class GenerateShell extends AppShell {
	public $tasks = array(
		'Ember.Controller',
		'Ember.Model',
		'Ember.View',
		'Ember.Route'
	);

	public function main() {
		$this->out(__d('cake_console', 'Interactive Ember Bake Shell'));
		$this->hr();
		$this->out(__d('cake_console', '[M]odel'));
		$this->out(__d('cake_console', '[V]iew'));
		$this->out(__d('cake_console', '[C]ontroller'));
		$this->out(__d('cake_console', '[R]oute'));
		$this->out(__d('cake_console', '[Q]uit'));
		$validResponse = array('M', 'V', 'C', 'R', 'Q');
		$classToBake = strtoupper($this->in(
			__d('cake_console', 'What would you like to generate?'),
			$validResponse
		));
		switch ($classToBake) {
			case 'M':
				$this->Model->execute();
				break;
			case 'V':
				$this->View->execute();
				break;
			case 'C':
				$this->Controller->execute();
				break;
			case 'R':
				$this->Route->execute();
				break;
			case 'Q':
				exit(0);
				break;
			default:
				$this->out(__d('cake_console', 'You have made an invalid selection. Please choose a type of class to generate by entering M, V, C, R, or Q.'));
		}
		$this->hr();
	}
}
