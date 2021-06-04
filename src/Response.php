<?php namespace ApiRest;

class Response {
	protected $_status;
	protected $_body;
	protected $_info;
	protected $_headers; 
	protected $_cookies;
	protected $_json;

	public function __construct(string $response='', array $info=[]) {
		$headerlen = intval($info[CURLINFO_HEADER_SIZE] ?? '0');
		$this->_status = intval($info[CURLINFO_RESPONSE_CODE] ?? '0');
		$this->_body = substr($response, $headerlen);
		$this->_info = $info;

		// build headers array
		$headerText = substr($response, 0, $headerlen);
		$this->_headers = Http::parseHeader($headerText);
		
		// build cookies array
		$cookieText = $this->_headers['cookie'] ?? '';
		$this->_cookies = Http::parseCookie($cookieText);
	}

	public function status() :int {
		return $this->_status;
	}

	// status ok
	public function ok() :bool {
		return ($this->_status == Http::STATUS_OK);
	}

	/**
	 * if the call redirected. if redirected, returns >0. else, 0.
	 */
	public function redirected() :int {
		return $this->_info[CURLINFO_REDIRECT_COUNT] ?? 0;
	}

	/**
	 * error message
	 */
	public function error() {
		if($this->ok()) {
			return null;
		} else {
			return $this->_body ?? true;
		}
	}

	/**
	 * get cURL info. refer https://www.php.net/manual/en/function.curl-getinfo.php
	 */
	public function info($key) {
		if(!is_int($key)) {
			$key = strtoupper($key);
			$key = eval("return CURLINFO_$key;");
		}
		return $this->_info[$key] ?? null;
	}

	/**
	 * get headers 
	 * @return array
	 */
	public function headers() :array {
		return $this->_headers;
	}

	/**
	 * get header option value.
	 * @return mixed header value, null if the key not exists.
	 */
	public function header(string $key, bool $multiple=false) {
		$_key = strtolower($key);
		$rets = null;
		foreach($this->_headers as $i=>$header) {
			if($header[0] == $_key) {
				if(!$multiple) {
					return $header[1];
				} else {
					if(!$rets) { $rets = []; }
					array_push($rets, $header[1]);
				}
			}
		}

		return $multiple ? null : $rets;
	}

	/**
	 * get response cookie
	 * @return array
	 */
	public function cookies() :array {
		return $this->_cookies;
	}

	/**
	 * get cookie by key.
	 * @return string cookie value, null if the key not exists.
	 */
	public function cookie(string $key) :string {
		return $this->_cookies[$key] ?? null;
	}


	/**
	 * 
	 */
	public function text() {
		return $this->_body;
	}

	/**
	 * return json array. cacheing for later use;
	 * @return array
	 */
	public function json() {
		if(!$this->_json) {
			$this->_json = json_decode($this->_body);
		}
		return $this->_json;
	}

	/**
	 * return json associative object. the assoc object does not cached.
	 * @return object
	 */
	public function jsonObject() {
		return json_decode($this->_body, true);
	}

	public function __str() {
		return $this->text();
	}

	public function __get($name) {
		return $this->json()[$name];
	}
}