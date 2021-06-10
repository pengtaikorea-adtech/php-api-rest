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
			$this->equals(gettype($r), 'integer', $v);
			$this->equals($r, $i, $v);
		}
	}

	public function methodOptionProvider() {
		return [
			[	
				'get', 
				[
					CURLOPT_HTTPGET => true,
					CURLOPT_POST => null,
					CURLOPT_PUT => null,
					CURLOPT_CUSTOMREQUEST => null,
				],
			],
			[
				'post',
				[
					CURLOPT_HTTPGET=>null,
					CURLOPT_POST=>true,
					CURLOPT_PUT=>null,
					CURLOPT_CUSTOMREQUEST=>null,
				],
			],
			[
				'put',
				[
					CURLOPT_HTTPGET=>null,
					CURLOPT_POST=>null,
					CURLOPT_PUT=>true,
					CURLOPT_CUSTOMREQUEST=>null,
				],
			],
			[
				'delete',
				[
					CURLOPT_HTTPGET=>null,
					CURLOPT_POST=>null,
					CURLOPT_PUT=>null,
					CURLOPT_CUSTOMREQUEST=>Http::METHOD_DEL,
				],
			],
			[
				'patch',
				[
					CURLOPT_HTTPGET=>false,
					CURLOPT_POST=>null,
					CURLOPT_PUT=>null,
					CURLOPT_CUSTOMREQUEST=>Http::METHOD_DEL,
				],
			]

		];
	}
	
	/**
	 * @dataProvider methodOptionProvider
	 */
	public function testSetMethod(string $method, array $expects) {
		$options = [
			CURLOPT_HTTPGET=>true,
			CURLOPT_POST=>true,
			CURLOPT_PUT=>true,
			CURLOPT_CUSTOMREQUEST=>'ANY',
		];
		// set
		cURL::setMethodOptions($method, $options);
		
		$this->true(is_array($options) && 0<count($options));

		// test with expected
		foreach($options as $key=>$exp)	{
			if($exp===null) {
				$this->false(array_key_exists($key, $options));
			} else {
				$this->equals($options[$key], $exp);
			}
		}
	}

	public function testSetMethodBlank() {
		foreach(Http::NAME_METHODS as $i=>$method) {
			$options = [];
			$options = cURL::setMethodOptions($method, $options);
			$this->true(is_array($options));
			$this->true(0<count($options));
		}
	}

	public function testSetMethodWrong() {
		$wrongMethodNames = ['SETS', 'VALUE', 'METHOD'];
		foreach($wrongMethodNames as $i=>$method) {
			$options = [];
			$this->false(cURL::setMethodOptions($method, $options));
		}
	}

}