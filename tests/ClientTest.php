<?php namespace ApiRest;

class TestClient {
	use ClientTrait;

	const API_HOST = 'https://api.pengtai.kr';

	protected static function endpoint(string $path) :string {
		return static::endpointWithhost(self::API_HOST, $path);
	}

	/**
	 * @override
	 */
	public function beforeSend(Request &$req) {
		return $req;
	}

	/**
	 * @override
	 */
	public function onResponsed(Request $req, Response $resp) {
		return $resp;
	}
}

class ClientTest extends TestCase {
	public function testBuildClient() {
		$client = new TestClient();
		$this->true($client!=null);
	}

	public function testSetCommonHeader() {
		$client = new TestClient();
		$client->appendHeader('Accept', 'Value');

		$this->true(0<$client->headers());

		$actual = $client->findHeader('accept');
		$this->equals('Value', $actual);
	}

	public function testSetCommonCookie() {
		$client = new TestClient();
		$client->setCookie('Key', 'Value');

		$cookies = $client->cookies();
		$this->true(is_array($cookies));
		$this->true(0<count($cookies));
		$this->equals($cookies['Key'], 'Value');
	}

	public function testSetCommonCookieWithRequest() {
		$client = new TestClient();
		$client->setCookie('Key', 'Value');
		
		$req = new Request($client->options());
		$value = $req->cookie('Key');
		$this->equals($value, 'Value');
	}

}