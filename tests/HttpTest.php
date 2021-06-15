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
				[$k, $v] = explode(":", $s);
				$k = strtolower(trim($k));
				$v = trim($v);
				$this->true(array_key_exists($k, $expected));
				$this->equals($v, $expected[$k]);
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

	public function testStringifyCookies() {
		$cookies = [
			'key1'=>'v1',
			'key2'=>'v2',
		];
		$cookieString = Http::stringifyCookies($cookies);
		$this->true(is_string($cookieString));
		$this->true(0<strlen($cookieString));
		$this->true(0<preg_match("/key1=v1/", $cookieString));
		$this->true(0<preg_match("/key2=v2/", $cookieString));
		$actuals = Http::parseCookie($cookieString);
		$this->equals(count($cookies), count($actuals));
		foreach($cookies as $ck=>$cv) {
			$this->true(array_key_exists($ck, $cookies));
			$this->equals($cookies[$ck], $cv);
		}
	}
}