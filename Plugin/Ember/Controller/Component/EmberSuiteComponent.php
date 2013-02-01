<?php
/**
 * This single component will bring together all the individual components and
 * helpers that the Ember plugin will provide.
 */

App::uses('Component', 'Controller');

class EmberSuiteComponent extends Component {
	/**
	 * Default pluginName that the components and helpers come from
	 * @var string
	 */
	public $pluginName = 'Ember';

	/**
	 * Components and Helpers that need to be loaded into the controller
	 * @var array
	 */
	public $_loadComponents = array('EmberData');
	public $_loadHelpers = array('Handlebars');

	/**
	 * Check the controller helpers array for the presence of the Handlebar helper
	 * and if it doesn't exist, add it. Also load other components into the
	 * controller
	 *
	 * @access public
	 * @param Controller $controller
	 */
	public function startup(Controller $controller) {
		foreach ($this->_loadComponents as $c) {
			$component = $this->pluginName . '.' . $c;
			$controller->{$c} = $controller->Components->load($component);
		}

		$helpers = array();
		if (is_array($controller->helpers)) {
			$helpers = $controller->helpers;
		}

		foreach ($this->_loadHelpers as $h) {
			$helper = $this->pluginName . '.' . $h;
			if (!isset($helpers[$helper]) && array_search($helper, $helpers) === false) {
				$helpers = array_merge($helpers, array($helper));
			}
		}

		$controller->helpers = $helpers;
	}
}
