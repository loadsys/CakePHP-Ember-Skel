<?php
/**
 * This single component will bring together all the individual components and
 * helpers that the Ember plugin will provide.
 */

App::uses('Component', 'Controller');

class EmberSuiteComponent extends Component {
	public $components = array('Ember.EmberData');

	/**
	 * Check the controller helpers array for the presence of the Handlebar helper
	 * and if it doesn't exist, add it.
	 *
	 * @access public
	 * @param Controller $controller
	 */
	public function initialize(Controller $controller) {
		$key = 'Ember.Handlebars';
		$helpers = array();
		if (is_array($controller->helpers)) {
			$helpers = $controller->helpers;
		}
		if (!isset($helpers[$key]) && array_search($key, $helpers) === false) {
			$controller->helpers = array_merge($helpers, array($key));
		}
	}
}
