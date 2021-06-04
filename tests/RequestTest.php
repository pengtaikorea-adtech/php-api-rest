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
		$req = new Request(static::testLocation);
		$this->equals(static::testLocation, $req->location());
	}

	public function testRequestHeaders() {
		$req = new Request('', static::testHeaders);

		$this->equals(count(static::testHeaders), count($req->headers()));

		foreach(static::testHeaders as $k=>$v) {
			$this->equals($v, $req->header($k));
		}

		$this->true($req->header('')==null);
	}

	public function testRequestCookieArray() {
		$req = new Request('', null, static::testCookies);
		$this->equals(count(static::testCookies), count($req->cookies()));

		foreach(static::testCookies as $k=>$v) {
			$this->equals($v, $req->cookie($k));
		}

		$this->true($req->cookie('')==null);
	}

	public function testRequestCookieText() {
		$req = new Request('', null, static::testCookiesText);
		$this->equals(count(static::testCookies), count($req->cookies()));

		foreach(static::testCookies as $k=>$v) {
			$this->equals($v, $req->cookie($k));
		}

		$this->true($req->cookie('')==null);
	}
}