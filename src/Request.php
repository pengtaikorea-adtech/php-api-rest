<?php namespace ApiRest;

class Request {
	protected $_url;
	protected $_headers;
	protected $_cookies;

	public function __construct(string $location='', ?array $headers=[], $cookies='') {
		$this->_url = $location;
		$this->_headers = $headers ?? [];
		if(is_string($cookies)) {
			$this->_cookies = Http::parseCookie($cookies);
		} else {
			$this->_cookies = $cookies ?? [];
		}
	}

	public function location():string {
		return $this->_url ?? '';
	}

	public function headers():array {
		return $this->_headers;
	}

	public function header(string $key): ?string {
		return $this->_headers[$key] ?? null;
	}

	public function cookies() {
		return $this->_cookies;
	}

	public function cookie(string $key): ?string {
		return $this->_cookies[$key] ?? null;
	}
}