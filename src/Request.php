<?php namespace ApiRest;

class Request {
	// __get, __set magic trait
	use cURLOptionMagic;
	
	// cookie cache
	protected $_cookies;
	protected $_options;

	public function __construct(?array $options=null) {
		$this->_options = $options ?? [];
	}

	public function location():?string {
		return $this->_options[CURLOPT_URL] ?? null;
	}

	public function setLocation(string $location) {
		$this->_options[CURLOPT_URL] = $location;
	}

	public function setParam(string $key, $value) {

	}

	public function headers():array {
		return $this->_options[CURLOPT_HTTPHEADER] ?? [];
	}

	public function header(string $key) :?string {
		return Http::findHeader($this->headers(), $key);
	}

	public function headerValues(string $key) :array {
		return Http::searchHeaders($this->headers(), $key);
	}

	public function appendHeader(string $key, string $value) {
		$headers = $this->_options[CURLOPT_HTTPHEADER] ?? [];

		array_push($headers, "$key: $value");
		$this->_options[CURLOPT_HTTPHEADER] = $headers;
	}

	public function spliceHeader(string $key, ?string $value=null) {
		$pattern = Http::headerSearchPattern($key);
		$match = [];
		$this->_options[CURLOPT_HTTPHEADER] = array_filter($this->headers(), 
			function($line) use ($pattern, &$match) {
				return !(preg_match($pattern, $line, $match) 
					&& ($value===null || $value=trim($match['val'])));
		});
	}

	public function replaceHeaders(array $headers) {
		$this->_options[CURLOPT_HTTPHEADER] = $headers;
	}

	public function cookies():array {
		if(!$this->_cookies) {
			$this->_cookies = array_key_exists(CURLOPT_COOKIE, $this->_options) 
				? Http::parseCookie($this->_options[CURLOPT_COOKIE])
				: [];
		}
		return $this->_cookies;
	}

	public function cookie(string $key): ?string {
		$cookies = $this->cookies();
		return $cookies[$key] ?? null;
	}

	public function setCookies(array $cookies) {
		$this->cookies();
		foreach($cookies as $ck=>$cv) {
			$this->_cookies[$ck] = $cv;
		}
	}

	public function setCookie(string $key, string $value)  {
		$this->cookies();
		$this->_cookies[$key] = $value;
	}

	public function unsetCookie(string $key) {
		if(is_array($this->_cookies) && array_key_exists($key, $this->_cookies)) {
			unset($this->_cookie[$key]);
		}
	}

	public function __get($key) {
		return cURL::getOption($this->_options, $key);
	}
	
	public function __set($key, $value) {
		cURL::setOption($this->_options, $key);
	}

}