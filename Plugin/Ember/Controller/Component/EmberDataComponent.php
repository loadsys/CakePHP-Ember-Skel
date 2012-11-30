<?php

App::uses('Component', 'Controller');

class EmberDataComponent extends Component {
	public $dataKey = 'ember';

	public function setup(Controller $controller) {
		$data = array();
		if ($controller->request->is('put')) {
			$data = json_decode($this->request->data, true);
		} elseif ($controller->request->is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
		}
		$controller->request->{$this->dataKey} = $data;
	}

	public function serialize($Model, $data = null) {
		$return = array();
		if (!$data || empty($data)) {
			return array();
		}
		$name = $Model->name;
		if (is_numeric(key($data))) {
		}
	}
}