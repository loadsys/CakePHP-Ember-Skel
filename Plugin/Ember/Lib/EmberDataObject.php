<?php

class EmberDataObject implements ArrayAccess {
	private $object = array();

	public function __construct($initial = array()) {
		if (is_array($initial)) {
			$this->object = $initial;
		}
	}

	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->object[] = $value;
		} else {
			$this->object[$offset] = $value;
		}
	}

	public function offsetExists($offset) {
		return isset($this->object[$offset]);
	}

	public function offsetUnset($offset) {
		unset($this->object[$offset]);
	}

	public function offsetGet($offset) {
		return isset($this->object[$offset]) ? $this->object[$offset] : null;
	}
}
