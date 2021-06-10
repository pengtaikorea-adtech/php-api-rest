<?php namespace ApiRest;

class HttpTest extends TestCase {
	const urlparseTestset = './data/url_test_sets.yaml';
	const headerParseTestset = './data/header_test_sets.yml';

	public function testImplodeUrl() {
		$testset = $this->fromYml(static::urlparseTestset);

		foreach($testset as $i=>$ts) {
			$parsed = Http::buildURI($ts);
			$this->true(strcmp($ts['expect'], $parsed)==0);
		}
	}

	public function testParseHeaderRegexp() {
		$match = [];
		preg_match(Http::HEADER_PATTERN, 'MimeType: text/plain', $match);
		$this->equals(trim($match['key']), 'MimeType');
		$this->equals(trim($match['val']), 'text/plain');
	}

	public function testFindHeaderKeyRegexp() {
		$key = "hello";
		$pattern = Http::headerSearchPattern($key);
		// exact match
		$this->true(preg_match($pattern, "hello: world"));
		// case insensitivity
		$this->true(preg_match($pattern, "Hello: world"));
		// case insensitivity + blank
		$this->true(preg_match($pattern, "Hello :   world"));
	}

	public function testFindHeaderKey() {
		$headers = [
			"Hello: World",
			"Hi : there ",
		];
		// case insensitivity
		$world = Http::findHeader($headers, "Hello");
		$this->equals($world, "World");
		// blank
		$there = Http::findHeader($headers, "hi");
		$this->equals($there, "there");


	}

	public function testParseHeader() {
		$testsets = $this->fromYml(static::headerParseTestset);

		foreach($testsets as $i=>$ts) {
			$parsed = Http::parseHeader($ts['raw']);
			$expected = $ts['expect'];

			$this->equals(count($parsed), count($expected));

			foreach($parsed as $j=>$s) {
				$this->true(count($s)==2);
				$this->true(array_key_exists($s[0], $expected));
				$this->equals($s[1], $expected[$s[0]]);
			}
		}
	}

	public function testParseCookie() {
		$test = 'a=b;c=d; e=f;';
		$expect = ['a'=>'b', 'c'=>'d', 'e'=>'f'];
		$parsed = Http::parseCookie($test);

		$this->true(is_array($parsed));
		$this->equals(count($parsed), count($expect));
		foreach($expect as $k=>$v) {
			$this->true(array_key_exists($k, $parsed));
			$this->equals($parsed[$k], $v);
		}
	}

	public function testLoadSetCookiePattern() {
		$eKey = 'Key';
		$eVal = 'Value';
		$tests = [
			"$eKey=$eVal",
			"$eKey=$eVal;",
			"$eKey=$eVal; Expires=3600",
			"$eKey=$eVal; Expires=3600; Secured=True;",
		];


		foreach($tests as $t) {
			$match = [];
			$this->true(!!preg_match(Http::SETCOOKIE_PATTERN, $t, $match));
			$this->equals($match['key'], $eKey);
			$this->equals($match['val'], $eVal);
		}
	}

	public function testLoadSetCookie() {
		$test = 'Key=Value; Expires=3600; Secured=True;';
		$eKey = 'Key';
		$eVal = 'Value';

		$cookies = [];
		$parsed = Http::loadSetCookie($test, $cookies);

		$this->true(array_key_exists($eKey, $cookies));
		$this->equals($cookies[$eKey], $eVal);
	}
}