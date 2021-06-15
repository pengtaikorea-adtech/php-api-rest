<?php namespace ApiRest;

trait cURLOptionMagic {
	// $this->_options required

	public function __get($name) {
		return cURL::getOption($this->_options, $name);
	}

	public function __set($name, $value) {
		cURL::setOPtion($this->_options, $name, $value);
	}
}