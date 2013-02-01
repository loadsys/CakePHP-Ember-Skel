<?php

App::uses('Controller', 'Controller');
App::uses('EmberDataComponent', 'Ember.Controller/Component');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');

class EmberDataTestController extends Controller {
	public $name = 'EmberDataTest';
	public $components = array('Ember.EmberData');
}

class TestEmberDataComponent extends EmberDataComponent {
	public $__testFormData = '';
	public function formData() {
		return $this->__testFormData;
	}
}

class EmberDataComponentTest extends CakeTestCase {
	public $EmberData;
	public $Controller;
	public $request;

	public function setUp() {
		parent::setUp();
		$this->request = new CakeRequest('ember_data_test/index');
		$this->Controller = new EmberDataTestController($this->request);
		$this->EmberData = new TestEmberDataComponent($this->getMock('ComponentCollection'), array());
		$this->EmberData->Controller = $this->Controller;
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->EmberData, $this->Controller, $this->request);
	}

	public function testPutData() {
		$data = '{ "Post": { "title": "Post Title" } }';
		$expected = array('Post' => array('title' => 'Post Title'));
		$this->Controller->request = $this->getMock('CakeRequest', array('isPut', 'isPost'));
		$this->Controller->request->expects($this->once())
															->method('isPut')
															->will($this->returnValue(true));
		$this->Controller->request->data = $data;
		$this->EmberData->startup($this->Controller);
		$this->assertEqual($this->Controller->request->ember, $expected);
	}

	public function testPostData() {
		$data = '{ "User": { "name": "Test User" } }';
		$expected = array('User' => array('name' => 'Test User'));
		$this->Controller->request = $this->getMock('CakeRequest', array('isPut', 'isPost'));
		$this->Controller->request->expects($this->once())
															->method('isPut')
															->will($this->returnValue(false));
		$this->Controller->request->expects($this->once())
															->method('isPost')
															->will($this->returnValue(true));
		$this->EmberData->__testFormData = $data;
		$this->EmberData->startup($this->Controller);
		$this->assertEqual($this->Controller->request->ember, $expected);
	}

	public function testDataKey() {
		$data = '{ "Course": { "name": "Course Name" } }';
		$expected = array('Course' => array('name' => 'Course Name'));
		$this->Controller->request = $this->getMock('CakeRequest', array('isPut', 'isPost'));
		$this->Controller->request->expects($this->once())
															->method('isPut')
															->will($this->returnValue(true));
		$this->Controller->request->data = $data;
		$this->EmberData->dataKey = 'testKey';
		$this->EmberData->startup($this->Controller);
		$this->assertEqual($this->Controller->request->testKey, $expected);
	}
}