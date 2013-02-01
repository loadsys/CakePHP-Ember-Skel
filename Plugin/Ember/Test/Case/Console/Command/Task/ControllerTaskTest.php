<?php

App::uses('ControllerTask', 'Ember.Console/Command/Task');

class TestControllerTask extends ControllerTask {
	public function generateFile($name, $type = null) {
		return $this->generateFileContent($name, $type);
	}
}

class ControllerTaskTest extends CakeTestCase {
	public function setUp() {
		$this->task = new TestControllerTask();
	}

	public function tearDown() {
		unset($this->task);
	}

	public function testGenerateFile() {
		$expected = "App.IndexController = Ember.Controller.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'controller'), 'msg');
	}

	public function testGenerateFileCollection() {
		$expected = "App.IndexController = Ember.ArrayController.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'array'), 'msg');
	}

	public function testGenerateFileContainer() {
		$expected = "App.IndexController = Ember.ObjectController.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'object'), 'msg');
	}

	public function testGenerateFileInvalid() {
		$expected = "App.IndexController = Ember.Controller.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'invalid'), 'msg');
	}

	public function testGenerateFileEmpty() {
		$expected = "App.IndexController = Ember.Controller.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index'), 'msg');
	}
}
