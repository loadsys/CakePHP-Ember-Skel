<?php

App::uses('Component', 'Controller');

class EmberDataComponent extends Component {
	public $dataKey = 'ember';

	public function startup(Controller $controller) {
		$data = array();
		if ($controller->request->isPut()) {
			$data = json_decode($controller->request->data, true);
		} elseif ($controller->request->isPost()) {
			$data = json_decode($this->formData(), true);
		}
		$controller->request->{$this->dataKey} = $data;
	}

	protected function formData() {
		return file_get_contents('php://input');
	}
}