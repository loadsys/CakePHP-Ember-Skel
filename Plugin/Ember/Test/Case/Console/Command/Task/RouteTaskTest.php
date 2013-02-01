<?php

App::uses('RouteTask', 'Ember.Console/Command/Task');

class TestRouteTask extends RouteTask {
	public function generateFile($name, $type = null) {
		return $this->generateFileContent($name, $type);
	}
}

class RouteTaskTest extends CakeTestCase {
	public function setUp() {
		$this->task = new TestRouteTask();
	}

	public function tearDown() {
		unset($this->task);
	}

	public function testGenerateFile() {
		$expected = "App.IndexRoute = Ember.Route.extend({\n\n});";
		$this->assertEqual($expected, $this->task->generateFile('index'), 'msg');
	}
}
