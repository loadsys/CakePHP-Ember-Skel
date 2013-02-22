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
	public $_componentOptions = array();
	public $_loadHelpers = array('Handlebars');
	public $_helperOptions = array();

	/**
	 * Pulling the helpers and components options out of the options out
	 * of the options array if they exist.
	 *
	 * @access public
	 * @param ComponentCollection $collection
	 * @param array $options
	 */
	public function __construct(ComponentCollection $collection, $options = array()) {
		if (isset($options['helpers'])) {
			$this->_helperOptions = $options['helpers'];
			unset($options['helpers']);
		}
		if (isset($options['components'])) {
			$this->_componentOptions = $options['components'];
			unset($options['components']);
		}
		parent::__construct($collection, $options);
	}

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
			$options = $this->extractOptions($this->_componentOptions, array($c, $component));
			$controller->{$c} = $controller->Components->load($component, $options);
		}

		$helpers = array();
		if (is_array($controller->helpers)) {
			$helpers = $controller->helpers;
		}

		foreach ($this->_loadHelpers as $h) {
			$helper = $this->pluginName . '.' . $h;
			if (!isset($helpers[$helper]) && array_search($helper, $helpers) === false) {
				$merge = array($helper);
				$options = $this->extractOptions($this->_helperOptions, array($h, $helper));
				if ($options) {
					$merge = array($helper => $options);
				}
				$helpers = array_merge($helpers, $merge);
			}
		}

		$controller->helpers = $helpers;
	}

	public function extractOptions($source, $keys = array()) {
		$return = null;
		foreach ($keys as $key) {
			if (isset($source[$key])) {
				$return = $source[$key];
			}
		}
		return $return;
	}
}
