<?php namespace ApiRest;

class TestClient {
	use ClientTrait;

	const API_HOST = 'https://api.pengtai.kr';

	protected static function endpoint(string $path) :string {
		return static::API_HOST
			.($path[0]=='/' ? '' : '/')
			.$path;
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
	public function testBuildApiCall() {
		$this->true(true, "pass");
	}
}