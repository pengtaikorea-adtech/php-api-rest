<?php namespace ApiRest;

class ResponseTest extends TestCase {
	const responseTestSet = 'resp_test_sets.yaml';

	protected function parseInfo(array $testset) {
		$rets = [];
		foreach($testset['info'] ?? [] as $k=>$v) {
			$k = strtoupper($k);
			$key = eval("return CURLINFO_$k;");
			$rets[$key] = $v;
		}
		return $rets;
	}

	protected function expectations(Response $resp, array $ts) {
		$expect = $ts['expect'] ?? [];

		// expecting header
		$eHeaders = $expect['header'] ?? [];
		foreach($eHeaders as $key=>$val) {
			$this->equals($val, $resp->header($key));
		}

		// expecting body json
		$eJson = $expect['json'] ?? [];
		foreach($eJson as $key=>$val) {
			$this->equals($val, $resp->$key);
		}
	}

	public function testBuildResponse() {
		$nullResponse = new Response();
		$this->true($nullResponse!=null);
	}

	public function testResponseOk() {
		$testset = $this->fromYml(static::responseTestSet);
		$_resp = $testset['respok'];
		$resp = new Response($_resp['raw'], $this->parseInfo($_resp));

		$this->expectations($resp, $_resp);
	}

	public function testResponseRedirect() {
		$resp = new Response('', [
			CURLINFO_REDIRECT_COUNT => 1,
		]);
		$this->true(0<$resp->redirected());
	}

	public function testResponseError() {
		$message = 'error';
		$respOK = new Response($message, [
			CURLINFO_RESPONSE_CODE => Http::STATUS_OK,
		]);
		$this->true($respOK->ok());
		$this->true($respOK->error()==null);

		$respErr = new Response($message, [
			CURLINFO_RESPONSE_CODE => 501,
		]);
		$this->false($respErr->ok());
		$this->equals($respErr->error(), $message);
	}
}