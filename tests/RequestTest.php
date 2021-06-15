<?php namespace ApiRest;

class RequestTest extends TestCase {

	const testLocation = 'https://pengtai.co.kr';
	const testHeaders = [
		'mimeType' => 'text/json',
		'test' => 'value',
		'Accepts' => 'null',
	];
	const testCookies = [
		'key1' => 'value',
		'key2' => 'val',
		'key3' => '유니코드',
	];
	const testCookiesText = 'key1=value;key2=val; key3 = 유니코드';

	public function testBuildRequest() {
		$nullRequest = new Request();
		
		$this->true($nullRequest!=null);
	}

	public function testRequestLocation() {
		$req = new Request([
			CURLOPT_URL=>static::testLocation
		]);
		$this->equals(static::testLocation, $req->location());
	}

	public function testRequestSetLocation() {
		$req = new Request();
		$req->setLocation(static::testLocation);
		$this->equals(static::testLocation, $req->location());
	}

	public function testRequestHeaders() {
		// setup headers
		$headers = [];
		foreach(static::testHeaders as $hk=>$hv) {
			array_push($headers, "$hk: $hv");
		}
		$req = new Request([CURLOPT_HTTPHEADER=>$headers]);
		$this->equals(count(static::testHeaders), count($req->headers()));

		foreach(static::testHeaders as $k=>$v) {
			$this->equals($v, $req->header($k));
		}

		$this->true($req->header('')==null);
	}

	public function testRequestAppendHeaders() {

		$req = new Request([
			CURLOPT_URL=>static::testLocation,
		]);
		foreach(static::testHeaders as $hk=>$hv) {
			$req->appendHeader($hk, $hv);
		}

		$this->equals(count(static::testHeaders), count($req->headers()));

		foreach(static::testHeaders as $k=>$v) {
			$this->equals($v, $req->header($k));
		}

		$this->true($req->header('')==null);
	}

	public function testRequestCookieArray() {
		$req = new Request();
		$req->setCookies(static::testCookies);

		$this->equals(count(static::testCookies), count($req->cookies()));

		foreach(static::testCookies as $k=>$v) {
			$this->equals($v, $req->cookie($k));
		}

		$this->true($req->cookie('')==null);
	}

	public function testRequestCookieText() {
		$req = new Request([
			CURLOPT_COOKIE => static::testCookiesText,	
		]);
		$this->equals(count(static::testCookies), count($req->cookies()));

		foreach(static::testCookies as $k=>$v) {
			$this->equals($v, $req->cookie($k));
		}

		$this->true($req->cookie('')==null);
	}
}