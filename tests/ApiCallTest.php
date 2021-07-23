<?php namespace ApiRest;

class ApiCallTest extends TestCase {
	public function testBuildBlankApiCall() {
		$api = new ApiCall();
		$this->true($api !=null);
	}

	public function testApiCallGet() {
		$location = 'http://pengtai.co.kr';
		$call = new ApiCall($location);
		// send get
		$resp = $call->get();

		// test it ok
		if($resp->ok()) {
			// show text
			$this->true(0<strlen($resp->text()));
		} else {
			// show error message
			$this->true(false, "http fail");
		}
	}
}