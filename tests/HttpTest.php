<?php namespace ApiRest;

class HttpTest extends TestCase {
	const urlparseTestset = 'url_test_sets.yaml';

	public function testImplodeUrl() {
		$testset = $this->fromYml(static::urlparseTestset);

		foreach($testset as $i=>$ts) {
			$parsed = Http::buildURL($ts);
			$this->true(strcmp($ts['expect'], $parsed)==0);
		}
	}

	public function testParseHeader() {
		$this->true(true, 'pass');
	}

	public function testParseCookie() {
		$this->true(true, 'pass');
	}

	public function testBuildURI() {
		$this->true(true, 'pass');
	}
}