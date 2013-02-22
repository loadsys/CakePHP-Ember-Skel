<?php

App::uses('Controller', 'Controller');
App::uses('EmberSuiteComponent', 'Ember.Controller/Component');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');

class EmberSuiteTestController extends Controller {
	public $name = 'EmberSuiteTest';
	public $components = array('Ember.EmberSuite');
}

class TestEmberSuiteComponent extends EmberSuiteComponent {}

class EmberSuiteComponentTest extends CakeTestCase {
	public $EmberSuite;
	public $Controller;
	public $request;

	public function setUp() {
		parent::setUp();
		$this->request = new CakeRequest('ember_data_test/index');
		$this->Controller = new EmberSuiteTestController($this->request);
		$this->EmberSuite = new TestEmberSuiteComponent($this->getMock('ComponentCollection'), array());
		$this->EmberSuite->Controller = $this->Controller;
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->EmberSuite, $this->Controller, $this->request);
	}

	public function testComponentLoadsHelpers() {
		$this->Controller->helpers = array();
		$this->EmberSuite->startup($this->Controller);
		$this->assertEqual($this->Controller->helpers, array('Ember.Handlebars'));
	}

	public function testComponentLoadsHelperWithPluginNameSet() {
		$this->Controller->helpers = array();
		$this->EmberSuite->pluginName = 'CakeEmber';
		$this->EmberSuite->startup($this->Controller);
		$this->assertEqual($this->Controller->helpers, array('CakeEmber.Handlebars'));
	}

	public function testComponentLoadsEmberData() {
		$this->assertFalse(isset($this->Controller->EmberData));
		$this->EmberSuite->startup($this->Controller);
		$this->assertTrue(isset($this->Controller->EmberData));
	}

	public function testComponentAndHelperOptionsAreTakenOutOfOptionsArray() {
		$options = array(
			'helpers' => array('setting' => 'value'),
			'components' => array('value' => 'setting')
		);
		$EmberSuite = new TestEmberSuiteComponent($this->getMock('ComponentCollection'), $options);
		$this->assertEqual(array('setting' => 'value'), $EmberSuite->_helperOptions);
		$this->assertEqual(array('value' => 'setting'), $EmberSuite->_componentOptions);
	}

	public function testPassesOptionsForHandlebarsHelperToTheHelper() {
		$Controller = new EmberSuiteTestController($this->request);
		$options = array(
			'helpers' => array('Handlebars' => array('compile' => false)),
		);
		$EmberSuite = new TestEmberSuiteComponent($this->getMock('ComponentCollection'), $options);
		$EmberSuite->startup($Controller);
		$expected = array('Ember.Handlebars' => array('compile' => false));
		$this->assertEqual($expected, $Controller->helpers);
	}

	public function testPassesOptionsForEmberDataComponentToComponent() {
		$Controller = new EmberSuiteTestController($this->request);
		$options = array(
			'components' => array('EmberData' => array('dataKey' => 'emberData')),
		);
		$EmberSuite = new TestEmberSuiteComponent($this->getMock('ComponentCollection'), $options);
		$EmberSuite->startup($Controller);
		$this->assertEqual('emberData', $Controller->EmberData->dataKey);
	}
}
