<?php

App::uses('ModelTask', 'Ember.Console/Command/Task');

class TestModelTask extends ModelTask {
	public function generateFile($name, $type = null, $extras = null) {
		return $this->generateFileContent($name, $type, $extras);
	}
}

class ModelTaskTest extends CakeTestCase {
	public function setUp() {
		$this->task = new TestModelTask();
	}

	public function tearDown() {
		unset($this->task);
	}

	public function testGenerateFile() {
		$expected = "App.Post = DS.Model.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('post', 'model'), 'msg');
	}

	public function testGenerateClassType() {
		$expected = "Model";
		$this->assertEqual($expected, $this->task->generateClassType('model'), 'msg');
	}

	public function testHandlesPropertiesPassedWithCommand() {
		$expected = "App.Post = DS.Model.extend({
	body: DS.attr('string'),
	version: DS.attr('number'),
	isPublished: DS.attr('boolean'),
	pubDate: DS.attr('date')
});";
		$extras = array('body:string', 'version:number', 'isPublished:boolean', 'pubDate:date');
		$this->assertEqual($expected, $this->task->generateFile('post', 'model', $extras));
	}

	public function testHandlesPropertiesPassedWithCommandWithMissingType() {
		$expected = "App.Post = DS.Model.extend({
	body: DS.attr('string'),
	version: DS.attr('number'),
	isPublished: DS.attr('boolean'),
	pubDate: DS.attr('date')
});";
		$extras = array('body', 'version:number', 'isPublished:bool', 'pubDate:date');
		$this->assertEqual($expected, $this->task->generateFile('post', 'model', $extras));
	}
}
