<?php

class EmberSuiteTest extends CakeTestSuite {
	public static function suite() {
		$suite = new CakeTestSuite('All Ember Plugin Tests');
		$base = APP . 'Plugin' . DS . 'Ember' . DS . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($base . 'View');
		$suite->addTestDirectoryRecursive($base . 'Controller');
		$suite->addTestDirectoryRecursive($base . 'Console');
		$suite->addTestDirectoryRecursive($base . 'Lib');
		return $suite;
	}
}
