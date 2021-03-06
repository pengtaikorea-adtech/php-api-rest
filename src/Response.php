<?php namespace ApiRest;

class Response {
	protected $_status;
	protected $_body;
	protected $_info;
	protected $_headers; 
	protected $_cookies;
	protected $_json;

	public function __construct(string $body='', array $info=[]) {
		$headerlen = intval($info[cURL::KEY_INFO_HEADER_LENGTH] ?? '0');
		$this->_status = intval($info[cURL::KEY_INFO_STATUS] ?? Http::STATUS_OK);
		$this->_body = substr($body, $headerlen);
		$this->_info = $info;

		// build headers array
		$headerText = substr($body, 0, $headerlen);
		$this->_headers = Http::parseHeader($headerText);

		// build cookies array
		$cookieText = $this->header('cookie') ?? '';
		$this->_cookies = Http::parseCookie($cookieText);

		// appending responsed cookies
		foreach($this->header('set-cookie', true) ?? [] as $i=>$cookie) {
			Http::loadSetCookie($cookie, $this->_cookies);
		}
	}

	public function status() :int {
		return $this->_status ?? $this->_info[cURL::KEY_INFO_STATUS];
	}

	// status ok
	public function ok() :bool {
		return ($this->status() === Http::STATUS_OK);
	}

	/**
	 * if the call redirected. if redirected, returns >0. else, 0.
	 */
	public function redirected() :int {
		return $this->_info[cURL::KEY_INFO_REDIRECT_COUNT] ?? 0;
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
		return $this->_info[strtolower($key)] ?? null;
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
		if($multiple) {
			return Http::searchHeaders($this->_headers, $key);
		} else {
			return Http::findHeader($this->_headers, $key);
		}
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
			$this->_json = json_decode($this->_body, true);
		}
		return $this->_json;
	}

	/**
	 * return json associative object. the assoc object does not cached.
	 * @return object
	 */
	public function jsonObject() {
		return json_decode($this->_body, false);
	}

	public function __toString() {
		return $this->text();
	}

	public function __get($name) {
		$dict = $this->json();
		return $dict[$name] ?? null;
	}
}