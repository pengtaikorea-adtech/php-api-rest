<?php namespace ApiRest;

class CURLTest extends TestCase {
	public function testConstantLoading() {
		$values = [
			'autoreferer' => CURLOPT_AUTOREFERER,
			'certinfo' => CURLOPT_CERTINFO,
		];
		foreach($values as $v=>$i) {
			$r = cURL::key($v);
			// log
			echo "$v => $r".PHP_EOL;
			$this->equals(gettype($r), 'integer', $v);
			$this->equals($r, $i, $v);
		}
	}

}