<?php

App::uses('ViewTask', 'Ember.Console/Command/Task');

class TestViewTask extends ViewTask {
	public function generateFile($name, $type = null) {
		return $this->generateFileContent($name, $type);
	}
}

class ViewTaskTest extends CakeTestCase {
	public function setUp() {
		$this->task = new TestViewTask();
	}

	public function tearDown() {
		unset($this->task);
	}

	public function testGenerateFile() {
		$expected = "App.IndexView = Ember.View.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'view'), 'msg');
	}

	public function testGenerateFileCollection() {
		$expected = "App.IndexView = Ember.CollectionView.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'collection'), 'msg');
	}

	public function testGenerateFileContainer() {
		$expected = "App.IndexView = Ember.ContainerView.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'container'), 'msg');
	}

	public function testGenerateFileInvalid() {
		$expected = "App.IndexView = Ember.View.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index', 'invalid'), 'msg');
	}

	public function testGenerateFileEmptyType() {
		$expected = "App.IndexView = Ember.View.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index'), 'msg');
	}
}
