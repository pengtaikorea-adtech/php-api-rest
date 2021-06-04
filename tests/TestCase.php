<?php namespace ApiRest;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase {
	public function __call($name, $args) {
		$fn = "assert".ucfirst(strtolower($name));
		if(method_exists($this, $fn)) {
			$this->$fn(...$args);
		}
	}

	protected function fromYml(string $path) {
		return \Symfony\Component\Yaml\Yaml::parseFile(__DIR__."/$path");
	}
}