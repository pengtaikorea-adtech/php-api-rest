<?php namespace ApiRest;

class Request {
	// cookie cache
	protected $_cookies;
	protected $_options;

	public function __construct(array $options) {
		$this->_options = $options;
	}

	public function location():string {
		return $this->_options[CURLOPT_URL];
	}

	public function headers():array {
		return $this->_options[CURLOPT_HTTPHEADER];
	}

	public function header(string $key) :string {
		return Http::findHeader($this->headers(), $key);
	}

	public function headerValues(string $key) :array {
		return Http::searchHeaders($this->headers(), $key);
	}

	public function appendHeader(string $key, string $value) {
		array_push($this->_options[CURLOPT_HTTPHEADER], "$key: $value");
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
			$this->_cookies = Http::parseCookie($this->_options[CURLOPT_COOKIE]) ?? [];
		}
		return $this->_cookies;
	}

	public function cookie(string $key): ?string {
		$cookies = $this->cookies();
		return $cookies[$key] ?? null;
	}

	public function setCookie(string $key, string $value)  {
		$this->_cookies[$key] = $value;
	}

	public function unsetCookie(string $key) {
		unset($this->_cookie[$key]);
	}
}